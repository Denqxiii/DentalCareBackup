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
        'message',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    /**
     * Define the relationship with the Patient model.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'treatment_id', 'id'); // or whatever the service model is
    }
}