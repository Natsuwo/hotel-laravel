<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;


Route::post('messages/mark-as-read/{id}', [MessageController::class, 'markAsRead'])
  ->name('admin.message.markAsRead')
  ->middleware('role:concierge');
Route::resource('messages', MessageController::class)
  ->names('admin.message')
  ->middleware('role:concierge');
