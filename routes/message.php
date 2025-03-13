<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::resource('role:concierge', MessageController::class)
  ->names('admin.message')
  ->middleware('auth');
