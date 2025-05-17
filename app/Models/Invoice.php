<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'total_amount',
        'paid_amount',
        'status',
        'notes',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    protected $appends = ['balance'];

    /**
     * Get the balance of the invoice
     *
     * @return float
     */
    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * Get the patient associated with the invoice
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    /**
     * Get the appointment associated with the invoice
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the payments for the invoice
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include overdue invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->whereDate('due_date', '<', now())
                    ->where('status', '!=', 'paid');
    }

    /**
     * Scope a query to only include pending invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}