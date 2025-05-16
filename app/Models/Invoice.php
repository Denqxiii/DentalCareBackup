<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number',
        'patient_id',
        'total_amount',
        'paid_amount',
        'balance',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}