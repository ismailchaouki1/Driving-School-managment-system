<?php

namespace App\Exports;

use App\Models\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SessionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $sessions;

    public function __construct($sessions = null)
    {
        $this->sessions = $sessions;
    }

    public function collection()
    {
        return $this->sessions ?? Session::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Start Time',
            'End Time',
            'Student Name',
            'Student Category',
            'Student Type',
            'Student Phone',
            'Instructor Name',
            'Session Type',
            'Status',
            'Duration (min)',
            'Price (DH)',
            'Payment Status',
            'Vehicle Plate',
            'Location',
            'Notes',
            'Created At',
        ];
    }

    public function map($session): array
    {
        return [
            $session->id,
            $session->date,
            $session->start_time,
            $session->end_time,
            $session->student_name,
            $session->student_category,
            $session->student_type,
            $session->student_phone ?? 'N/A',
            $session->instructor_name,
            $session->type,
            $session->status,
            $session->duration,
            number_format($session->price, 2),
            $session->payment_status,
            $session->vehicle_plate ?? 'N/A',
            $session->location ?? 'N/A',
            $session->notes ?? 'N/A',
            $session->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
