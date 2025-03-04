<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingController::class, 'show'])
  ->name('api.settings.show');

Route::middleware('auth:guest')->group(function () {});
