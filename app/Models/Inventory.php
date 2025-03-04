<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected $table = 'inventory';
    protected $fillable = [
        'name',
        'description',
        'category',
        'gallery_id',
        'stock_quantity',
        'reorder_level',
        'safety_stock',
        'purchase_price',
        'selling_price',
        'last_order_date',
        'last_received_date',
        'supplier_id',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function supplier()
    {
        return $this->belongsTo(InventorySupplier::class, 'supplier_id');
    }
}
