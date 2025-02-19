<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomTypesController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/room_types/create', [RoomTypesController::class, 'create'])->name('admin.room_types.create');
Route::post('/admin/room_types/store', [RoomTypesController::class, 'store'])->name('admin.room_types.store');
Route::get('/admin/room_types/index', [RoomTypesController::class, 'index'])->name('admin.room_types.index');
Route::get('/admin/room_types/slug', [RoomTypesController::class, 'checkSlug'])->name('admin.room_types.slug');
Route::get('/admin/room_types/{id}', [RoomTypesController::class, 'getRoomById'])->name('admin.room_types.show');
Route::get('/admin/room_types/{id}/edit', [RoomTypesController::class, 'edit'])->name('admin.room_types.edit');

Route::put('/admin/room_types/{id}', [RoomTypesController::class, 'update'])->name('admin.room_types.update');
Route::delete('/admin/room_types/{id}', [RoomTypesController::class, 'destroy'])->name('admin.room_types.destroy');
