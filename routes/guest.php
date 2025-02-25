<?php

use App\Http\Controllers\GuestsController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/guest/index', [GuestsController::class, 'index'])->name('admin.guest.index');
Route::get('/admin/guest/create', [GuestsController::class, 'create'])->name('admin.guest.create');
Route::get('/admin/guest/{id}/edit', [GuestsController::class, 'edit'])->name('admin.guest.edit');
Route::get('/admin/guest/make-uid', [GuestsController::class, 'makeUid'])->name('admin.guest.make-uid');
Route::get('/admin/guest/get-guest', [GuestsController::class, 'getGuests'])->name('admin.guest.get-guest');

Route::post('/admin/guest/store', [GuestsController::class, 'store'])->name('admin.guest.store');
Route::put('/admin/guest/{id}', [GuestsController::class, 'update'])->name('admin.guest.update');
Route::delete('/admin/guest/{id}', [GuestsController::class, 'destroy'])->name('admin.guest.destroy');
