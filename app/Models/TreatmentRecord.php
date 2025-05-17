<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentRecord extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'treatment_date', 'treatment_details'];

    /**
     * Define the relationship with the Patient model.
     */
    public function patient() {
    return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function treatment() {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }
}
