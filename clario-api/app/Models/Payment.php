<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'student_id',
        'session_id',
        'vehicle_id',
        'student_name',
        'student_cin',
        'student_phone',
        'student_email',
        'category',
        'payment_category',
        'amount_total',
        'amount_paid',
        'amount_remaining',
        'status',
        'method',
        'type',
        'date',
        'due_date',
        'instructor',
        'notes',
        'receipt_number',
        'payment_reference',
    ];

    protected $casts = [
        'amount_total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_remaining' => 'decimal:2',
        'date' => 'date',
        'due_date' => 'date',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
