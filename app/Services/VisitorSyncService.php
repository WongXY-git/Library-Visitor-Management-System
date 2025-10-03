<?php

namespace App\Services;

use App\Models\SenseVisitor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class VisitorSyncService
{
    protected $senselinkApi;

    public function __construct(SenselinkApiService $senselinkApi)
    {
        $this->senselinkApi = $senselinkApi;
    }

    /**
     * Pull visitor records from external API based on identification criteria
     * 
     * Criteria for visitor records:
     * 1. unique_id must be exactly 10 digits
     * 2. financial_hold must be 'N'
     * 3. type must be '1'
     *
     * @return Collection
     */
    public function pullVisitorRecords(): Collection
    {
        try {
            // In the future, this will use proper API filtering
            $records = $this->senselinkApi->fetchVisitors([
                'type' => SenseVisitor::VISITOR_TYPE,
                'financial_hold' => SenseVisitor::VISITOR_FINANCIAL_HOLD,
            ]);

            // Filter locally to ensure we only get visitor records
            return collect($records)->filter(function ($record) {
                return isset($record['unique_id']) &&
                       strlen($record['unique_id']) === SenseVisitor::VISITOR_ID_LENGTH &&
                       preg_match('/^[0-9]{' . SenseVisitor::VISITOR_ID_LENGTH . '}$/', $record['unique_id']) &&
                       ($record['type'] ?? null) === SenseVisitor::VISITOR_TYPE &&
                       ($record['financial_hold'] ?? null) === SenseVisitor::VISITOR_FINANCIAL_HOLD;
            });
        } catch (\Exception $e) {
            Log::error('Error pulling visitor records', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return collect();
        }
    }

    /**
     * Sync visitor records from API to local database
     * 
     * This ensures all visitor records are properly stored with:
     * - Constant values (financial_hold='N', type='1')
     * - Proper unique_id format (10 digits)
     * - Preserved remarks
     *
     * @return array Statistics about the sync operation
     */
    public function syncVisitors(): array
    {
        $stats = [
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'failed' => 0,
            'skipped' => 0
        ];

        try {
            $records = $this->pullVisitorRecords();
            
            foreach ($records as $record) {
                $stats['processed']++;

                try {
                    // Find existing record or create new one
                    $visitor = SenseVisitor::firstOrNew([
                        'unique_id' => $record['unique_id']
                    ]);

                    $isNew = !$visitor->exists;

                    // Preserve existing remarks if updating
                    $remarks = $isNew ? null : $visitor->remarks;

                    // Update visitor data
                    $visitor->fill($record);
                    
                    // Ensure constants are set
                    $visitor->financial_hold = SenseVisitor::VISITOR_FINANCIAL_HOLD;
                    $visitor->type = SenseVisitor::VISITOR_TYPE;
                    
                    // Restore remarks if updating
                    if (!$isNew) {
                        $visitor->remarks = $remarks;
                    }

                    if ($visitor->save()) {
                        $isNew ? $stats['created']++ : $stats['updated']++;
                    }
                } catch (\Exception $e) {
                    $stats['failed']++;
                    Log::error('Error syncing visitor record', [
                        'record' => $record,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return $stats;

        } catch (\Exception $e) {
            Log::error('Error in visitor sync process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $stats;
        }
    }
}