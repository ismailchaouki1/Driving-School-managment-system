<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'first_name' => 'Youssef',
                'last_name' => 'Alami',
                'cin' => 'AB123456',
                'age' => 22,
                'email' => 'youssef.alami@gmail.com',
                'phone' => '0612345678',
                'address' => '45 Rue Mohammed V, Casablanca',
                'type' => 'B',
                'initial_payment' => 3000,
                'total_price' => 6000,
                'payment_status' => 'Partial',
                'registration_date' => '2025-01-15',
                'parent_name' => 'Mohammed Alami',
                'emergency_contact' => '0612345679',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Fatima',
                'last_name' => 'Benali',
                'cin' => 'CD789012',
                'age' => 19,
                'email' => 'fatima.benali@gmail.com',
                'phone' => '0698765432',
                'address' => '12 Avenue Hassan II, Rabat',
                'type' => 'B',
                'initial_payment' => 6000,
                'total_price' => 6000,
                'payment_status' => 'Complete',
                'registration_date' => '2025-01-10',
                'parent_name' => 'Ahmed Benali',
                'emergency_contact' => '0698765433',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Karim',
                'last_name' => 'Cherkaoui',
                'cin' => 'EF345678',
                'age' => 35,
                'email' => 'karim.ch@outlook.com',
                'phone' => '0655443322',
                'address' => 'Gueliz District, Marrakech',
                'type' => 'C',
                'initial_payment' => 0,
                'total_price' => 9000,
                'payment_status' => 'Pending',
                'registration_date' => '2025-01-18',
                'parent_name' => null,
                'emergency_contact' => '0655443323',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Nadia',
                'last_name' => 'Tazi',
                'cin' => 'GH901234',
                'age' => 27,
                'email' => 'nadia.tazi@gmail.com',
                'phone' => '0611223344',
                'address' => 'Medina, Fez',
                'type' => 'A',
                'initial_payment' => 4500,
                'total_price' => 4500,
                'payment_status' => 'Complete',
                'registration_date' => '2025-01-22',
                'parent_name' => 'Omar Tazi',
                'emergency_contact' => '0611223345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Hassan',
                'last_name' => 'Ouazzani',
                'cin' => 'IJ567890',
                'age' => 31,
                'email' => 'hassan.o@gmail.com',
                'phone' => '0677889900',
                'address' => 'Hivernage, Marrakech',
                'type' => 'BE',
                'initial_payment' => 2000,
                'total_price' => 7500,
                'payment_status' => 'Partial',
                'registration_date' => '2025-02-03',
                'parent_name' => 'Fatima Ouazzani',
                'emergency_contact' => '0677889901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
