<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'amount',
        'date',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected $dates = ['payment_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getDateAttribute()
{
    return $this->payment_date;
}

    public function getAmountAttribute()
    {
        return $this->payment_amount;
    }

    public function getStatusAttribute()
    {
        return $this->payment_status;
    }

    public function getPaymentMethodAttribute()
    {
        return $this->payment_method;
    }

    public function getNotesAttribute()
    {
        return $this->payment_notes;
    }
}