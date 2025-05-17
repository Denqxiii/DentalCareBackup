<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'name', 'description', 'category',
        'current_quantity', 'low_stock_threshold'
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}