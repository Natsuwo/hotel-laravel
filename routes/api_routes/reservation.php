<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RoomTypesController;
use Illuminate\Support\Facades\Route;


Route::get('/rooms', [RoomTypesController::class, 'index'])->name('api.rooms.index');
Route::get('/rooms/{id}', [RoomTypesController::class, 'getRoomById'])->name('api.rooms.show');
Route::get('/roomtypes/{id}', [RoomTypesController::class, 'getRoomTypesById'])->name('api.roomtypes.show');
Route::get('/rooms/{id}/reservations', [ReservationsController::class, 'show'])
  ->name('api.reservations.index.room');

Route::get('/reservation/room_number/{id}', [ReservationsController::class, 'getByRoomNumber'])
  ->name('api.reservations.room_number.index');
Route::get('/gallery', [GalleryController::class, 'index'])->name('api.gallery.index');




Route::middleware('auth:guest')->group(function () {
  Route::post('/reservation/create', [ReservationsController::class, 'store'])
    ->name('api.reservations.store');

  Route::get('/reservation/{id}', [ReservationsController::class, 'getById'])
    ->name('api.reservations.show');
  Route::get('/reservation/guest/{id}', [ReservationsController::class, 'getByGuestId'])
    ->name('api.reservations.guest.show');

  Route::put('/reservation/{id}', [ReservationsController::class, 'update'])
    ->name('api.reservations.update');
  Route::delete('/reservation/{id}', [ReservationsController::class, 'destroy'])
    ->name('api.reservations.delete');

  Route::post('/payment/create', [PaymentController::class, 'store'])
    ->name('api.payment.store');

  Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('api.payment.show');
  Route::put('/payment/{id}', [PaymentController::class, 'update'])->name('api.payment.update');
  Route::get('/coupon/{id}', [CouponController::class, 'getOne'])->name('api.coupon.show');
});
