<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('driving_sessions')->insert([
            [
                'student_id' => 1,
                'student_name' => 'Youssef Alami',
                'student_category' => 'B',
                'student_type' => 'registered',
                'student_phone' => '0612345678',
                'student_email' => 'youssef.alami@gmail.com',
                'instructor_id' => 1,
                'instructor_name' => 'Mohammed Benali',
                'type' => 'Driving',
                'status' => 'Scheduled',
                'date' => now()->addDays(1)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '10:30:00',
                'duration' => 90,
                'price' => 200,
                'payment_status' => 'Pending',
                'vehicle_id' => 1,
                'vehicle_plate' => '12345-A-1',
                'location' => 'Driving Range A',
                'notes' => 'Focus on parallel parking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'student_name' => 'Fatima Benali',
                'student_category' => 'B',
                'student_type' => 'registered',
                'student_phone' => '0698765432',
                'student_email' => 'fatima.benali@gmail.com',
                'instructor_id' => 2,
                'instructor_name' => 'Fatima Zahra',
                'type' => 'Code',
                'status' => 'Completed',
                'date' => now()->subDays(2)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'duration' => 120,
                'price' => 150,
                'payment_status' => 'Paid',
                'vehicle_id' => null,
                'vehicle_plate' => null,
                'location' => 'Classroom 1',
                'notes' => 'Code review - passed with 85%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
