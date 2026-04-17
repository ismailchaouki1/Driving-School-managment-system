<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        try {
            // ✅ USE ELOQUENT MODEL, NOT DB FACADE
            $students = Student::orderBy('created_at', 'desc')->get();
            $studentsWithPayments = $students->map(function($student) {
            $totalPaid = $student->payments()->sum('amount_paid');
            $student->total_paid = $totalPaid;
            $student->remaining_balance = $student->total_price - $totalPaid;
            return $student;
        });
            return response()->json([
                'success' => true,
                'data' => $students,
                'message' => 'Students retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load students: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
{
    try {
        Log::info('Creating student with data:', $request->all());

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cin' => 'required|string|unique:students',
            'age' => 'required|integer|min:16',
            'email' => 'required|email|unique:students',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'type' => 'required|string',
            'initial_payment' => 'nullable|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'registration_date' => 'required|date',
            'parent_name' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        // Calculate payment status based on initial payment
        $initialPayment = $validated['initial_payment'] ?? 0;
        $totalPrice = $validated['total_price'];

        if ($initialPayment >= $totalPrice) {
            $validated['payment_status'] = 'Complete';
        } elseif ($initialPayment > 0) {
            $validated['payment_status'] = 'Partial';
        } else {
            $validated['payment_status'] = 'Pending';
        }

        // MANUALLY SET user_id - IMPORTANT!
        $validated['user_id'] = $request->user()->id;

        $student = Student::create($validated);

        // Create payment record if initial payment > 0
        if ($initialPayment > 0) {
            $reference = 'PAY-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $paymentStatus = $initialPayment >= $totalPrice ? 'Paid' : 'Partial';

            Payment::create([
                'reference' => $reference,
                'user_id' => $request->user()->id,
                'student_id' => $student->id,
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'student_cin' => $student->cin,
                'student_phone' => $student->phone,
                'student_email' => $student->email,
                'category' => $student->type,
                'payment_category' => 'registration',
                'amount_total' => $totalPrice,
                'amount_paid' => $initialPayment,
                'amount_remaining' => $totalPrice - $initialPayment,
                'status' => $paymentStatus,
                'method' => $request->method ?? 'Cash',
                'type' => 'Registration',
                'date' => now()->toDateString(),
                'due_date' => now()->addMonths(3)->toDateString(),
                'instructor' => $request->instructor ?? 'System',
                'notes' => 'Initial registration payment',
                'receipt_number' => 'RCP-' . str_pad($student->id, 6, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add payment totals to response
        $student->total_paid = $initialPayment;
        $student->remaining_balance = $totalPrice - $initialPayment;

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    } catch (\Exception $e) {
        Log::error('Failed to create student: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to create student: ' . $e->getMessage()
        ], 500);
    }
}

    public function show($id)
{
    try {
        $student = Student::findOrFail($id);
        $totalPaid = $student->payments()->sum('amount_paid');
        $student->total_paid = $totalPaid;
        $student->remaining_balance = $student->total_price - $totalPaid;

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found'
        ], 404);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);

            $validated = $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'cin' => ['sometimes', 'string', Rule::unique('students')->ignore($id)],
                'age' => 'sometimes|integer|min:16',
                'email' => ['sometimes', 'email', Rule::unique('students')->ignore($id)],
                'phone' => 'sometimes|string|max:20',
                'address' => 'nullable|string',
                'type' => 'sometimes|string',
                'initial_payment' => 'nullable|numeric|min:0',
                'total_price' => 'nullable|numeric|min:0',
                'payment_status' => 'sometimes|in:Complete,Partial,Pending',
                'registration_date' => 'sometimes|date',
                'parent_name' => 'nullable|string|max:255',
                'emergency_contact' => 'nullable|string|max:20',
            ]);

            $student->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update student: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete student: ' . $e->getMessage()
            ], 500);
        }
    }
    public function exportExcel(Request $request)
{
    try {
        $students = Student::all();
        $export = new StudentsExport($students);
        return Excel::download($export, 'students_' . date('Y-m-d') . '.xlsx');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Export failed: ' . $e->getMessage()
        ], 500);
    }
}

public function exportPdf(Request $request)
{
    try {
        $students = Student::all();
        $pdf = Pdf::loadView('exports.students-pdf', ['students' => $students]);
        return $pdf->download('students_' . date('Y-m-d') . '.pdf');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Export failed: ' . $e->getMessage()
        ], 500);
    }
}
public function printReceipt($id)
{
    try {
        $student = Student::findOrFail($id);
        $pdf = Pdf::loadView('exports.student-receipt', ['student' => $student]);
        return $pdf->download('receipt_' . $student->cin . '_' . date('Y-m-d') . '.pdf');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate receipt: ' . $e->getMessage()
        ], 500);
    }
}
public function addPayment(Request $request, $id)
{
    try {
        $student = Student::findOrFail($id);

        // Verify ownership
        if ($student->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|in:Cash,Bank Transfer,Card,Cheque,Online',
            'notes' => 'nullable|string',
        ]);

        $amount = $request->amount;
        $totalPaidSoFar = $student->payments()->sum('amount_paid');
        $remainingBalance = $student->total_price - $totalPaidSoFar;

        if ($amount > $remainingBalance) {
            return response()->json([
                'success' => false,
                'message' => 'Amount exceeds remaining balance. Remaining: ' . number_format($remainingBalance, 2) . ' MAD'
            ], 422);
        }

        // Calculate new total paid
        $newTotalPaid = $totalPaidSoFar + $amount;

        // Determine payment status
        if ($newTotalPaid >= $student->total_price) {
            $paymentStatus = 'Paid';
            $student->payment_status = 'Complete';
        } elseif ($newTotalPaid > 0) {
            $paymentStatus = 'Partial';
            $student->payment_status = 'Partial';
        } else {
            $paymentStatus = 'Pending';
        }

        // Generate unique reference
        $reference = 'PAY-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Create payment record
        $payment = Payment::create([
            'reference' => $reference,
            'user_id' => $request->user()->id,
            'student_id' => $student->id,
            'student_name' => $student->first_name . ' ' . $student->last_name,
            'student_cin' => $student->cin,
            'student_phone' => $student->phone,
            'student_email' => $student->email,
            'category' => $student->type,
            'payment_category' => 'registration',
            'amount_total' => $student->total_price,
            'amount_paid' => $amount,
            'amount_remaining' => $remainingBalance - $amount,
            'status' => $paymentStatus,
            'method' => $request->method,
            'type' => 'Registration',
            'date' => now()->toDateString(),
            'due_date' => $student->registration_date,
            'instructor' => $request->instructor ?? 'System',
            'notes' => $request->notes ?? 'Additional registration payment',
            'receipt_number' => 'RCP-' . str_pad($student->id, 6, '0', STR_PAD_LEFT) . '-' . time(),
        ]);

        $student->save();

        // Get updated totals
        $newTotalPaid = $student->payments()->sum('amount_paid');

        return response()->json([
            'success' => true,
            'message' => 'Payment added successfully',
            'data' => [
                'payment' => $payment,
                'student' => [
                    'id' => $student->id,
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'total_price' => $student->total_price,
                    'total_paid' => $newTotalPaid,
                    'remaining_balance' => $student->total_price - $newTotalPaid,
                    'payment_status' => $student->payment_status,
                ]
            ]
        ], 201);

    } catch (\Exception $e) {
        Log::error('Failed to add payment: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to add payment: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Get payment history for a student
 */
public function getPaymentHistory(Request $request, $id)
{
    try {
        $student = Student::findOrFail($id);

        // Verify ownership
        if ($student->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $payments = $student->payments()->orderBy('created_at', 'desc')->get();
        $totalPaid = $student->payments()->sum('amount_paid');

        return response()->json([
            'success' => true,
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'total_price' => $student->total_price,
                    'total_paid' => $totalPaid,
                    'remaining_balance' => $student->total_price - $totalPaid,
                    'payment_status' => $student->payment_status,
                ],
                'payments' => $payments
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to get payment history: ' . $e->getMessage()
        ], 500);
    }
}
}
