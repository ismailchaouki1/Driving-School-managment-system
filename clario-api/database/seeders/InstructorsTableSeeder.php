<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('instructors')->insert([
            [
                'first_name' => 'Mohammed',
                'last_name' => 'Benali',
                'email' => 'mohammed.benali@clario.com',
                'phone' => '0612345678',
                'address' => '45 Rue Mohammed V, Casablanca',
                'cin' => 'AB123456',
                'type' => 'Both',
                'status' => 'Active',
                'experience_level' => 'Senior',
                'years_experience' => 8,
                'hire_date' => '2017-03-15',
                'specialization' => 'Category B, C',
                'license_number' => 'IN-2024-001',
                'students_count' => 28,
                'sessions_count' => 156,
                'completion_rate' => 94,
                'rating' => 4.8,
                'revenue' => 31200,
                'available_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
                'available_hours' => json_encode(['start' => '08:00', 'end' => '18:00']),
                'notes' => 'Senior instructor with excellent track record',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Fatima',
                'last_name' => 'Zahra',
                'email' => 'fatima.zahra@clario.com',
                'phone' => '0698765432',
                'address' => '12 Avenue Hassan II, Rabat',
                'cin' => 'CD789012',
                'type' => 'Driving',
                'status' => 'Active',
                'experience_level' => 'Senior',
                'years_experience' => 7,
                'hire_date' => '2018-06-20',
                'specialization' => 'Category B, BE',
                'license_number' => 'IN-2024-002',
                'students_count' => 25,
                'sessions_count' => 142,
                'completion_rate' => 92,
                'rating' => 4.7,
                'revenue' => 28400,
                'available_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Saturday']),
                'available_hours' => json_encode(['start' => '09:00', 'end' => '19:00']),
                'notes' => 'Specializes in heavy vehicle training',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Karim',
                'last_name' => 'Tazi',
                'email' => 'karim.tazi@clario.com',
                'phone' => '0655443322',
                'address' => '8 Rue de la Liberté, Marrakech',
                'cin' => 'EF345678',
                'type' => 'Code',
                'status' => 'Active',
                'experience_level' => 'Intermediate',
                'years_experience' => 4,
                'hire_date' => '2020-01-10',
                'specialization' => 'Category B - Code',
                'license_number' => 'IN-2024-003',
                'students_count' => 22,
                'sessions_count' => 128,
                'completion_rate' => 89,
                'rating' => 4.6,
                'revenue' => 25600,
                'available_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
                'available_hours' => json_encode(['start' => '08:30', 'end' => '17:30']),
                'notes' => 'Code specialist, excellent theory teaching',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
