<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventorySupplier extends Model
{
    protected $table = 'inventory_supplier';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'contact_person',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'supplier_id');
    }
}
