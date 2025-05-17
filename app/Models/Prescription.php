<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'medication',
        'dosage',
        'frequency',
        'duration',
        'notes',
        'issued_date',
        'expiry_date'
    ];
    
    /**
     * Get the patient that the prescription belongs to.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}