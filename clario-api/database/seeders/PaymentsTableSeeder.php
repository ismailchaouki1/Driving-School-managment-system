<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'reference' => 'PAY-2025-001',
                'student_id' => 1,
                'session_id' => null,
                'vehicle_id' => null,
                'student_name' => 'Youssef Alami',
                'student_cin' => 'AB123456',
                'student_phone' => '0612345678',
                'student_email' => 'youssef.alami@gmail.com',
                'category' => 'B',
                'payment_category' => 'registration',
                'amount_total' => 6000,
                'amount_paid' => 3000,
                'amount_remaining' => 3000,
                'status' => 'Partial',
                'method' => 'Cash',
                'type' => 'Registration',
                'date' => '2025-01-15',
                'due_date' => '2025-04-15',
                'instructor' => 'Mohammed Benali',
                'notes' => 'First installment received',
                'receipt_number' => 'RCP-001',
                'payment_reference' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reference' => 'PAY-2025-002',
                'student_id' => 2,
                'session_id' => null,
                'vehicle_id' => null,
                'student_name' => 'Fatima Benali',
                'student_cin' => 'CD789012',
                'student_phone' => '0698765432',
                'student_email' => 'fatima.benali@gmail.com',
                'category' => 'B',
                'payment_category' => 'registration',
                'amount_total' => 6000,
                'amount_paid' => 6000,
                'amount_remaining' => 0,
                'status' => 'Paid',
                'method' => 'Bank Transfer',
                'type' => 'Registration',
                'date' => '2025-01-10',
                'due_date' => '2025-01-10',
                'instructor' => 'Fatima Zahra',
                'notes' => 'Full payment received',
                'receipt_number' => 'RCP-002',
                'payment_reference' => 'TRF-123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reference' => 'PAY-2025-003',
                'student_id' => 2,
                'session_id' => 2,
                'vehicle_id' => null,
                'student_name' => 'Fatima Benali',
                'student_cin' => 'CD789012',
                'student_phone' => '0698765432',
                'student_email' => 'fatima.benali@gmail.com',
                'category' => 'B',
                'payment_category' => 'session',
                'amount_total' => 150,
                'amount_paid' => 150,
                'amount_remaining' => 0,
                'status' => 'Paid',
                'method' => 'Cash',
                'type' => 'Session',
                'date' => now()->subDays(2)->toDateString(),
                'due_date' => now()->subDays(2)->toDateString(),
                'instructor' => 'Fatima Zahra',
                'notes' => 'Payment for Code session',
                'receipt_number' => 'RCP-SESS-000002',
                'payment_reference' => 'SESS-2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
