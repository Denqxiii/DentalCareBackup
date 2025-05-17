<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'address',
        'patient_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->patient_id = static::generatePatientId();
        });
    }

    public static function generatePatientId()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $id = '';
        
        for ($i = 0; $i < 5; $i++) {
            $id .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Ensure the ID is unique
        while (static::where('patient_id', $id)->exists()) {
            $id = static::generatePatientId();
        }
        
        return $id;
    }
}