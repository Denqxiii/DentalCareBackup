<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $primaryKey = 'patient_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id', 'first_name', 'middle_name', 'last_name', 
        'gender', 'birth_date', 'email', 'phone', 'address'
    ];

    public function medicalHistories(): HasMany
    {
        return $this->hasMany(MedicalHistory::class, 'patient_id', 'patient_id');
    }

    public function treatmentRecords(): HasMany
    {
        return $this->hasMany(TreatmentRecord::class, 'patient_id', 'patient_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'patient_id');
    }
}