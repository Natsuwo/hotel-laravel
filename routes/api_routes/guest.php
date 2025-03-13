<?php

use App\Http\Controllers\GuestsController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;


Route::get('guest/authentication-required', function () {
  return response()->json(['message' => 'Authentication required', 'success' => false], 401);
})->name('api.guests.login');


Route::post('guest/login', [GuestsController::class, 'guestLogin'])
  ->name('api.guests.login.store');


Route::post('guest/register', [GuestsController::class, 'store'])
  ->name('api.guests.register');

Route::post('guest/social-login', [GuestsController::class, 'socialLogin'])
  ->name('api.guests.social-login');

Route::middleware('auth:guest')->group(function () {
  Route::post('guest/rating', [RatingController::class, 'store'])->name('api.guests.rating.store');
  Route::get('guest/rating', [RatingController::class, 'show'])->name('api.guests.rating.index');

  Route::post('guest/confirm_password', [GuestsController::class, 'confirmPassword'])
    ->name('api.guests.confirm_password');
  Route::get('guest/me', [GuestsController::class, 'me'])->name('api.guests.me');
  Route::get('guest/membership', [GuestsController::class, 'getMemberShip'])->name('api.guests.membership');
  Route::get('guest/refresh', [GuestsController::class, 'refresh'])->name('api.guests.refresh');
  Route::put('guest/update/{id}', [GuestsController::class, 'update'])->name('api.guests.update');
  Route::put('guest/update-password', [GuestsController::class, 'updateWithPassword'])->name('api.guests.update-password');
  Route::post('guest/logout', [GuestsController::class, 'logout'])->name('api.guests.logout');
});
