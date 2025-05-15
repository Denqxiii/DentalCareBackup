<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Specify the table name explicitly
    protected $table = 'inventories';

    // Define the fillable attributes
    protected $fillable = [
        'item_name',
        'quantity_in_stock',
        'price_per_unit',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'inventory_id');
    }
}
