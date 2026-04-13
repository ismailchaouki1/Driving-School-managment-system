<?php
// app/Exports/StatisticsExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StatisticsExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Statistics Report';
    }

    public function headings(): array
    {
        return [];
    }

    public function array(): array
    {
        $rows = [];

        // ==================== TITLE SECTION ====================
        $rows[] = ['STATISTICS REPORT'];
        $rows[] = ['Generated on:', $this->data['exportDate']];
        $rows[] = ['Period:', ucfirst($this->data['dateRange'])];
        $rows[] = [];

        // ==================== EXECUTIVE SUMMARY ====================
        $rows[] = ['EXECUTIVE SUMMARY'];
        $rows[] = ['Total Revenue', number_format($this->data['totalRevenue']) . ' MAD'];
        $rows[] = ['Total Students', $this->data['totalStudents']];
        $rows[] = ['Total Sessions', $this->data['totalSessions']];
        $rows[] = ['Completion Rate', number_format($this->data['completionRate'], 1) . '%'];
        $rows[] = ['Total Instructors', $this->data['instructors']->count()];
        $rows[] = ['Total Vehicles', $this->data['vehicles']->count()];
        $rows[] = [];

        // ==================== QUICK STATISTICS ====================
        $rows[] = ['QUICK STATISTICS'];
        $rows[] = ['Metric', 'Value'];
        $rows[] = ['Fully Paid Students', $this->data['students']->where('payment_status', 'Complete')->count()];
        $rows[] = ['Partial Payment Students', $this->data['students']->where('payment_status', 'Partial')->count()];
        $rows[] = ['Pending Payment Students', $this->data['students']->where('payment_status', 'Pending')->count()];
        $rows[] = ['Completed Sessions', $this->data['sessions']->where('status', 'Completed')->count()];
        $rows[] = ['Scheduled Sessions', $this->data['sessions']->where('status', 'Scheduled')->count()];
        $rows[] = ['Cancelled Sessions', $this->data['sessions']->where('status', 'Cancelled')->count()];
        $rows[] = ['Active Vehicles', $this->data['vehicles']->where('status', 'Active')->count()];
        $rows[] = [];

        // ==================== REVENUE BREAKDOWN ====================
        $rows[] = ['REVENUE BREAKDOWN'];
        $rows[] = ['Payment Type', 'Amount (MAD)', 'Percentage'];

        $grandTotal = $this->data['registrationRevenue'] + $this->data['sessionRevenue'] + $this->data['examRevenue'];
        $rows[] = ['Registration Fees', number_format($this->data['registrationRevenue']), $grandTotal > 0 ? number_format(($this->data['registrationRevenue'] / $grandTotal) * 100, 1) . '%' : '0%'];
        $rows[] = ['Session Payments', number_format($this->data['sessionRevenue']), $grandTotal > 0 ? number_format(($this->data['sessionRevenue'] / $grandTotal) * 100, 1) . '%' : '0%'];
        $rows[] = ['Exam Fees', number_format($this->data['examRevenue']), $grandTotal > 0 ? number_format(($this->data['examRevenue'] / $grandTotal) * 100, 1) . '%' : '0%'];
        $rows[] = ['TOTAL', number_format($grandTotal), '100%'];
        $rows[] = [];

        // ==================== MONTHLY REVENUE ====================
        $rows[] = ['MONTHLY REVENUE TREND'];
        $rows[] = ['Month', 'Revenue (MAD)'];
        foreach ($this->data['months'] as $index => $month) {
            $rows[] = [$month, number_format($this->data['monthlyRevenue'][$index])];
        }
        $rows[] = [];

        // ==================== PAYMENT METHODS DISTRIBUTION ====================
        $rows[] = ['PAYMENT METHODS DISTRIBUTION'];
        $rows[] = ['Method', 'Transactions', 'Amount (MAD)', 'Percentage'];

        $totalAmount = array_sum(array_column($this->data['paymentMethods'], 'amount'));
        foreach ($this->data['paymentMethods'] as $method => $stats) {
            $percentage = $totalAmount > 0 ? round(($stats['amount'] / $totalAmount) * 100, 1) : 0;
            $rows[] = [$method, $stats['count'], number_format($stats['amount']), $percentage . '%'];
        }
        $rows[] = [];

        // ==================== CATEGORY DISTRIBUTION ====================
        $rows[] = ['CATEGORY DISTRIBUTION'];
        $rows[] = ['Category', 'Students', 'Percentage'];

        $totalStudents = $this->data['totalStudents'];
        foreach ($this->data['categoryDistribution'] as $category => $count) {
            $percentage = $totalStudents > 0 ? round(($count / $totalStudents) * 100, 1) : 0;
            $rows[] = ["Category {$category}", $count, $percentage . '%'];
        }
        $rows[] = [];

        // ==================== TOP INSTRUCTORS ====================
        $rows[] = ['TOP PERFORMING INSTRUCTORS'];
        $rows[] = ['Name', 'Sessions', 'Completion Rate', 'Revenue (MAD)', 'Rating'];
        foreach ($this->data['topInstructors'] as $instructor) {
            $rows[] = [
                $instructor->first_name . ' ' . $instructor->last_name,
                $instructor->sessions_count ?? 0,
                number_format($instructor->completion_rate ?? 0, 1) . '%',
                number_format($instructor->revenue ?? 0),
                number_format($instructor->rating ?? 0, 1),
            ];
        }
        $rows[] = [];

        // ==================== RECENT TRANSACTIONS ====================
        $rows[] = ['RECENT TRANSACTIONS'];
        $rows[] = ['Date', 'Student', 'Amount (MAD)', 'Type', 'Status', 'Method'];
        foreach ($this->data['recentTransactions'] as $transaction) {
            $rows[] = [
                $transaction->date,
                $transaction->student_name,
                number_format($transaction->amount_paid),
                $transaction->type,
                $transaction->status,
                $transaction->method ?? 'Cash',
            ];
        }
        $rows[] = [];

        // ==================== VEHICLE UTILIZATION ====================
        $rows[] = ['VEHICLE UTILIZATION'];
        $rows[] = ['Vehicle', 'Plate', 'Sessions', 'Utilization'];
        foreach ($this->data['vehicleUtilization'] as $vehicle) {
            $utilization = min(100, round((($vehicle->sessions_count ?? 0) / 300) * 100));
            $rows[] = [
                $vehicle->brand . ' ' . $vehicle->model,
                $vehicle->plate,
                $vehicle->sessions_count ?? 0,
                $utilization . '%',
            ];
        }
        $rows[] = [];

        // ==================== STUDENTS LIST ====================
        $rows[] = ['STUDENTS LIST'];
        $rows[] = ['ID', 'Name', 'Email', 'Phone', 'Category', 'Registration Date', 'Payment Status'];
        foreach ($this->data['students'] as $student) {
            $rows[] = [
                $student->id,
                $student->first_name . ' ' . $student->last_name,
                $student->email,
                $student->phone,
                $student->type,
                $student->registration_date,
                $student->payment_status,
            ];
        }
        $rows[] = [];

        // ==================== SESSIONS LIST ====================
        $rows[] = ['SESSIONS LIST'];
        $rows[] = ['ID', 'Student', 'Instructor', 'Date', 'Type', 'Status', 'Price (MAD)', 'Duration'];
        foreach ($this->data['sessions'] as $session) {
            $rows[] = [
                $session->id,
                $session->student_name,
                $session->instructor_name,
                $session->date,
                $session->type,
                $session->status,
                number_format($session->price),
                $session->duration . ' min',
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Style for main title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A1:F1');

        // Style for section headers
        $sectionRows = [5, 15, 23, 31, 37, 43, 51, 58, 66, 74];
        foreach ($sectionRows as $row) {
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle("A{$row}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('8cff2e');
        }

        // Style for table headers
        $headerRows = [6, 16, 24, 32, 38, 44, 52, 59, 67, 75];
        foreach ($headerRows as $row) {
            $sheet->getStyle("{$row}:{$row}")->getFont()->setBold(true);
            $sheet->getStyle("{$row}:{$row}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('e0e0e0');
        }

        // Add borders to all data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:F{$lastRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }
}
