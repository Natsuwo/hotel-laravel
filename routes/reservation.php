<?php

use App\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;


Route::middleware('role:concierge')->group(function () {
  Route::post('/admin/reservation/update-status', [ReservationsController::class, 'updateStatus'])->name('admin.reservation.update-status');
  Route::get('/admin/reservation/{guest_id}/profile', [ReservationsController::class, 'guestProfile'])->name('admin.reservation.profile');
  Route::resource('/admin/reservation', ReservationsController::class)->names('admin.reservation');
});
