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
        'type',
        'notes',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_patient_id', 'patient_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function getDateAttribute()
    {
        return $this->appointment_date;
    }

    public function getTimeAttribute()
    {
        return $this->appointment_time;
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}