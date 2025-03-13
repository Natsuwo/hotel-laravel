<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventorySupplierController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
  Route::resource('/admin/inventory', InventoryController::class)
    ->names('admin.inventory');
  Route::resource('/admin/inventory_supplier', InventorySupplierController::class)
    ->names('admin.inventory_supplier');
});
