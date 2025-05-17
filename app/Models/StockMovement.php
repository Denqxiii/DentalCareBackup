<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'inventory_item_id', 'type', 'quantity', 'notes'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }
}