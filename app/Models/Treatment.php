<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'cost',
        'duration',
        'category'
    ];
    
    /**
     * Get the appointments for this treatment.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // app/Models/Treatment.php

    public function scopeActive($query)
    {
        return $query->where('is_active', true); // or `->where('status', 'active')` depending on your setup
    }

}