<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vehicles')->insert([
            [
                'brand' => 'Dacia',
                'model' => 'Sandero',
                'year' => 2022,
                'plate' => '12345-A-1',
                'vin' => 'VF1ABCDE123456789',
                'category' => 'B',
                'fuel' => 'Gasoline',
                'transmission' => 'Manual',
                'color' => '#e74c3c',
                'status' => 'Active',
                'mileage' => 34200,
                'last_maintenance' => '2025-01-15',
                'next_maintenance' => '2025-07-15',
                'insurance_expiry' => '2025-12-31',
                'insurance_provider' => 'AXA Assurance',
                'assigned_instructor' => 'Mohammed Benali',
                'sessions_count' => 142,
                'purchase_price' => 120000,
                'current_value' => 85000,
                'fuel_efficiency' => 6.5,
                'notes' => 'Primary training vehicle for category B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand' => 'Renault',
                'model' => 'Clio',
                'year' => 2021,
                'plate' => '67890-B-2',
                'vin' => 'VF2BCDEF234567890',
                'category' => 'B',
                'fuel' => 'Diesel',
                'transmission' => 'Manual',
                'color' => '#3498db',
                'status' => 'Active',
                'mileage' => 52100,
                'last_maintenance' => '2025-02-20',
                'next_maintenance' => '2025-08-20',
                'insurance_expiry' => '2025-11-30',
                'insurance_provider' => 'Wafa Assurance',
                'assigned_instructor' => 'Fatima Zahra',
                'sessions_count' => 218,
                'purchase_price' => 135000,
                'current_value' => 92000,
                'fuel_efficiency' => 5.2,
                'notes' => 'Fuel-efficient vehicle for long distance training',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand' => 'Peugeot',
                'model' => '208',
                'year' => 2023,
                'plate' => '99887-E-5',
                'vin' => 'VF5EFGHI567890123',
                'category' => 'B',
                'fuel' => 'Electric',
                'transmission' => 'Automatic',
                'color' => '#9b59b6',
                'status' => 'Active',
                'mileage' => 8900,
                'last_maintenance' => '2025-03-20',
                'next_maintenance' => '2025-09-20',
                'insurance_expiry' => '2026-03-31',
                'insurance_provider' => 'Sanad Assurance',
                'assigned_instructor' => 'Karim Tazi',
                'sessions_count' => 44,
                'purchase_price' => 210000,
                'current_value' => 195000,
                'fuel_efficiency' => 0,
                'notes' => 'Electric vehicle for eco-driving sessions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
