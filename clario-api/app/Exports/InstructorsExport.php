<?php

namespace App\Exports;

use App\Models\Instructor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstructorsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $instructors;

    public function __construct($instructors = null)
    {
        $this->instructors = $instructors;
    }

    public function collection()
    {
        return $this->instructors ?? Instructor::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'CIN',
            'Address',
            'Type',
            'Status',
            'Experience Level',
            'Years Experience',
            'Hire Date',
            'Specialization',
            'License Number',
            'Students Count',
            'Sessions Count',
            'Completion Rate (%)',
            'Rating',
            'Revenue (MAD)',
            'Revenue per Session (MAD)',
            'Created At',
        ];
    }

    public function map($instructor): array
    {
        return [
            $instructor->id,
            $instructor->first_name,
            $instructor->last_name,
            $instructor->email,
            $instructor->phone ?? 'N/A',
            $instructor->cin,
            $instructor->address ?? 'N/A',
            $instructor->type,
            $instructor->status,
            $instructor->experience_level,
            $instructor->years_experience,
            $instructor->hire_date ?? 'N/A',
            $instructor->specialization ?? 'N/A',
            $instructor->license_number ?? 'N/A',
            $instructor->students_count,
            $instructor->sessions_count,
            number_format($instructor->completion_rate, 2),
            number_format($instructor->rating, 1),
            number_format($instructor->revenue, 2),
            number_format($instructor->revenue_per_session, 2),
            $instructor->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
