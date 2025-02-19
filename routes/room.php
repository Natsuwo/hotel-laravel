<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/room/create', [RoomController::class, 'create'])->name('admin.room.create');


Route::post('/admin/room/store', [RoomController::class, 'store'])->name('admin.room.store');
