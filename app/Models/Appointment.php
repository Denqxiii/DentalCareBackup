<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'treatment_type',
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i:s',
        'status',
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
}