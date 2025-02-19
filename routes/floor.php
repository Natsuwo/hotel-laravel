<?php

use App\Http\Controllers\FloorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/floor/index', [FloorController::class, 'index'])->name('admin.floor.index');
Route::get('/admin/floor/create', [FloorController::class, 'create'])->name('admin.floor.create');
Route::get('/admin/floor/detail/{id}', [FloorController::class, 'detail'])->name('admin.floor.detail');

Route::post('/admin/floor/create', [FloorController::class, 'store'])->name('admin.floor.store');
Route::put('/admin/floor/update/{id}', [FloorController::class, 'update'])->name('admin.floor.update');
Route::delete('/admin/floor/delete/{id}', [FloorController::class, 'delete'])->name('admin.floor.delete');
