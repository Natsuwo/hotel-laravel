<?php

use App\Http\Controllers\HousekeepingController;
use Illuminate\Support\Facades\Route;



Route::middleware('role:housekeeping')->group(function () {
  Route::patch('/admin/housekeeping/{id}/updateField', [HousekeepingController::class, 'updateField'])
    ->name('admin.housekeeping.updateStatus');
  Route::resource('admin/housekeeping', HousekeepingController::class)->names('admin.housekeeping');
});
