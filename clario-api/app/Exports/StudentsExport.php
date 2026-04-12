<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $students;

    public function __construct($students = null)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students ?? Student::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'First Name',
            'Last Name',
            'CIN',
            'Age',
            'Email',
            'Phone',
            'Address',
            'Category',
            'Total Price (MAD)',
            'Initial Payment (MAD)',
            'Remaining (MAD)',
            'Payment Status',
            'Registration Date',
            'Parent Name',
            'Emergency Contact',
            'Created At',
        ];
    }

    public function map($student): array
    {
        $remaining = $student->total_price - $student->initial_payment;

        return [
            $student->id,
            $student->first_name,
            $student->last_name,
            $student->cin,
            $student->age,
            $student->email,
            $student->phone,
            $student->address ?? 'N/A',
            $student->type,
            number_format($student->total_price, 2),
            number_format($student->initial_payment, 2),
            number_format($remaining, 2),
            $student->payment_status,
            $student->registration_date,
            $student->parent_name ?? 'N/A',
            $student->emergency_contact ?? 'N/A',
            $student->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
