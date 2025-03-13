<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;


Route::post('message/create', [MessageController::class, 'store'])
  ->name('api.message.create');
