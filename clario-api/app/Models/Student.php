<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'cin',
        'age',
        'email',
        'phone',
        'address',
        'type',
        'initial_payment',
        'total_price',
        'payment_status',
        'registration_date',
        'parent_name',
        'emergency_contact',
        'photo',
    ];

    // Optional: Add casts for proper data types
    protected $casts = [
        'age' => 'integer',
        'initial_payment' => 'decimal:2',
        'total_price' => 'decimal:2',
        'registration_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Optional: Add accessor for full name
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Optional: Add scope for filtering by payment status
    public function scopePaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    // Optional: Add scope for filtering by category
    public function scopeCategory($query, $category)
    {
        return $query->where('type', $category);
    }
}
