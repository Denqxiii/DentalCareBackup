<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['code', 'name', 'description', 'price', 'duration_minutes'];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}