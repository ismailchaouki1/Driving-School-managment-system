<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Exports\StudentsExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cin' => 'required|string|unique:students',
            'age' => 'required|integer|min:16',
            'email' => 'required|email|unique:students',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'type' => 'required|string|in:B,A,A1,C,D,BE',
            'initial_payment' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:Complete,Partial,Pending',
            'registration_date' => 'required|date',
            'parent_name' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cin' => ['required', 'string', Rule::unique('students')->ignore($student->id)],
            'age' => 'required|integer|min:16',
            'email' => ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'type' => 'required|string|in:B,A,A1,C,D,BE',
            'initial_payment' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:Complete,Partial,Pending',
            'registration_date' => 'required|date',
            'parent_name' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
     public function exportExcel(Request $request)
    {
        $students = $this->getFilteredStudents($request);

        $export = new StudentsExport($students);

        $filename = 'students_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download($export, $filename);
    }

    /**
     * Export students to CSV
     */
    public function exportCsv(Request $request)
    {
        $students = $this->getFilteredStudents($request);

        $export = new StudentsExport($students);

        $filename = 'students_' . date('Y-m-d_His') . '.csv';

        return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export students to PDF
     */
    public function exportPdf(Request $request)
    {
        $students = $this->getFilteredStudents($request);

        $pdf = Pdf::loadView('exports.students-pdf', ['students' => $students]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('students_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Get filtered students based on request parameters
     */
    private function getFilteredStudents(Request $request)
    {
        $query = Student::query();

        // Apply filters if provided
        if ($request->has('category') && $request->category !== 'All') {
            $query->where('type', $request->category);
        }

        if ($request->has('payment_status') && $request->payment_status !== 'All') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    /**
     * Print receipt for a single student
     */
    public function printReceipt(Student $student)
    {
        $pdf = Pdf::loadView('exports.student-receipt', ['student' => $student]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('receipt_' . $student->cin . '_' . date('Y-m-d') . '.pdf');
    }
}
