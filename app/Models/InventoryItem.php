<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_price',
        'reorder_level',
        'category',
        'supplier',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];
}