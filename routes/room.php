<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/room/create', [RoomController::class, 'create'])->name('admin.room.create');
Route::get('/admin/room/edit/{id}', [RoomController::class, 'edit'])->name('admin.room.edit');
Route::get('/admin/room/get-room', [RoomController::class, 'getRooms'])->name('admin.room.get-room');


Route::post('/admin/room/store', [RoomController::class, 'store'])->name('admin.room.store');
Route::put('/admin/room/update/{id}', [RoomController::class, 'update'])->name('admin.room.update');
Route::delete('/admin/room/destroy/{id}', [RoomController::class, 'destroy'])->name('admin.room.destroy');
