<?php

namespace Database\Seeders;

use App\Models\SenseVisitor;
use Illuminate\Database\Seeder;

class PlaceholderVisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * PLACEHOLDER: This seeder provides demo data and should not be used in production.
     * It will be replaced by actual API integration.
     */
    public function run(): void
    {
        $visitors = [
            [
                'sense_id' => 'V001',
                'unique_id' => '1234567890',
                'card_no' => 'LIB001',
                'name' => 'John Doe',
                'photo_path' => null,
                'active' => 'Y',
                'status' => 'Active',
                'remarks' => 'Regular library visitor',
                'updated_ts' => now(),
                'fr_create_ts' => now(),
                'fr_update_ts' => now(),
            ],
            [
                'sense_id' => 'V002',
                'unique_id' => '0987654321',
                'card_no' => 'LIB002',
                'name' => 'Jane Smith',
                'photo_path' => null,
                'active' => 'Y',
                'status' => 'Active',
                'remarks' => 'Research student',
                'updated_ts' => now(),
                'fr_create_ts' => now(),
                'fr_update_ts' => now(),
            ],
            [
                'sense_id' => 'V003',
                'unique_id' => '5678901234',
                'card_no' => 'LIB003',
                'name' => 'Alice Johnson',
                'photo_path' => null,
                'active' => 'Y',
                'status' => 'Active',
                'remarks' => 'Faculty member',
                'updated_ts' => now(),
                'fr_create_ts' => now(),
                'fr_update_ts' => now(),
            ],
        ];

        foreach ($visitors as $visitor) {
            SenseVisitor::create($visitor);
        }
    }
}