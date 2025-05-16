<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'treatment_id',
        'appointment_date',
        'appointment_time',
        'phone_number', // Added
        'gender',       // Added
        'notes',        // Changed from 'message'
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'date', // Cast appointment_date to a Carbon instance as a date
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function service()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }
}