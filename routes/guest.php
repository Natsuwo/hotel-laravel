<?php

use App\Http\Controllers\GuestsController;
use Illuminate\Support\Facades\Route;






Route::middleware('role:concierge')->group(function () {
  Route::get('/admin/guest/make-uid', [GuestsController::class, 'makeUid'])->name('admin.guest.make-uid');
  Route::get('/admin/guest/get-guest', [GuestsController::class, 'getGuests'])->name('admin.guest.get-guest');
  Route::resource('/admin/guest', GuestsController::class)->except(['destroy'])->names('admin.guest');
  Route::delete('/admin/guest/{guest}', [GuestsController::class, 'destroy'])->name('admin.guest.destroy')
    ->middleware('role:admin');
});
