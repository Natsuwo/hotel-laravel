<?php

use App\Http\Controllers\GuestsController;
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
  Route::post('guest/confirm_password', [GuestsController::class, 'confirmPassword'])
    ->name('api.guests.confirm_password');

  Route::get('guest/me', [GuestsController::class, 'me'])->name('api.guests.me');
  Route::get('guest/refresh', [GuestsController::class, 'refresh'])->name('api.guests.refresh');
  Route::put('guest/update/{id}', [GuestsController::class, 'update'])->name('api.guests.update');
  Route::put('guest/update-password', [GuestsController::class, 'updateWithPassword'])->name('api.guests.update-password');
  Route::post('guest/logout', [GuestsController::class, 'logout'])->name('api.guests.logout');

  // Route::post('login', [Guests::class, 'store']);

  // Route::get('forgot-password', [Guests::class, 'create'])
  //   ->name('password.request');

  // Route::post('forgot-password', [Guests::class, 'store'])
  //   ->name('password.email');

  // Route::get('reset-password/{token}', [Guests::class, 'create'])
  //   ->name('password.reset');

  // Route::post('reset-password', [Guests::class, 'store'])
  //   ->name('password.store');
});
