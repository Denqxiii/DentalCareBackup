<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedication extends Model
{
    protected $fillable = [
        'prescription_id',
        'name',
        'dosage',
        'frequency',
        'duration'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}