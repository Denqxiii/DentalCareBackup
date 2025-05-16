<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_method',
        'reference_number',
        'payment_number',
        'notes',
    ];

    /**
     * Get the invoice that the payment belongs to
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Generate a unique payment number
     * 
     * @return string
     */
    public static function generatePaymentNumber()
    {
        $latestPayment = self::latest()->first();
        $nextId = $latestPayment ? $latestPayment->id + 1 : 1;
        return 'PAY-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}