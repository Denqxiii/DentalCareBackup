<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'patient_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'patient_id',
        'first_name',
        'middle_name', 
        'last_name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'address'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->patient_id = $patient->patient_id ?? self::generatePatientId();
        });
    }

    public static function generatePatientId()
    {
        $prefix = 'PAT-';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return $prefix . $date . '-' . $random;
    }

    public function getRouteKeyName()
    {
        return 'patient_id';  // Use patient_id for route model binding
    }

    public function treatmentRecords() 
    {
    return $this->hasMany(TreatmentRecord::class, 'patient_id', 'patient_id');
    }

    public function treatments() {
        return $this->hasManyThrough(
            Treatment::class,
            TreatmentRecord::class,
            'patient_id',     // Foreign key on treatment_records table
            'id',             // Foreign key on treatments table (treatments.id)
            'patient_id',     // Local key on patients table
            'treatment_id'    // Local key on treatment_records table
        );
    }
}