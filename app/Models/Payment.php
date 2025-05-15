<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_number',
        'bill_id',
        'amount',
        'payment_method',
        'reference_number',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $payment->payment_number = 'PAY-' . strtoupper(Str::random(8));
        });

        static::created(function ($payment) {
            // Update bill status and amounts
            $bill = $payment->bill;
            $bill->paid_amount += $payment->amount;
            $bill->balance = $bill->total_amount - $bill->paid_amount;
            $bill->updateStatus();
        });
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
