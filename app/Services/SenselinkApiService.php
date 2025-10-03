<?php

namespace App\Services;

use App\Models\SenseVisitor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SenselinkApiService
{
    /**
     * Base URL for the Senselink API
     * This should be configured in .env
     */
    protected string $baseUrl;

    /**
     * API authentication token
     * This should be configured in .env
     */
    protected string $apiToken;

    public function __construct()
    {
        $this->baseUrl = config('services.senselink.url');
        $this->apiToken = config('services.senselink.token');
    }

    /**
     * Fetch visitor records from Senselink API
     *
     * @param array $params Optional query parameters
     * @return array|null
     */
    public function fetchVisitors(array $params = []): ?array
    {
        try {
            $response = Http::withToken($this->apiToken)
                ->get("{$this->baseUrl}/visitors", $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Senselink API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Senselink API exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Sync visitor data from API to database
     *
     * @return bool
     */
    public function syncVisitors(): bool
    {
        $visitors = $this->fetchVisitors();

        if (!$visitors) {
            return false;
        }

        try {
            foreach ($visitors as $visitorData) {
                SenseVisitor::updateOrCreate(
                    ['sense_id' => $visitorData['sense_id']],
                    $visitorData
                );
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Visitor sync error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Get a specific visitor by sense_id
     *
     * @param int $senseId
     * @return array|null
     */
    public function getVisitor(int $senseId): ?array
    {
        try {
            $response = Http::withToken($this->apiToken)
                ->get("{$this->baseUrl}/visitors/{$senseId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Senselink API error fetching visitor', [
                'sense_id' => $senseId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Senselink API exception fetching visitor', [
                'sense_id' => $senseId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }
}