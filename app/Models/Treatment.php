<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['name', 'price', 'description'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
