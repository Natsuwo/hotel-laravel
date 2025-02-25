<?php

use App\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/reservation/index', [ReservationsController::class, 'index'])->name('admin.reservation.index');
Route::get('/admin/reservation/create', [ReservationsController::class, 'create'])->name('admin.reservation.create');
Route::get('/admin/reservation/{id}/edit', [ReservationsController::class, 'edit'])->name('admin.reservation.edit');
Route::get('/admin/reservation/{guest_id}/profile', [ReservationsController::class, 'guestProfile'])->name('admin.reservation.profile');

Route::post('/admin/reservation/update-status', [ReservationsController::class, 'updateStatus'])->name('admin.reservation.update-status');
Route::post('/admin/reservation/store', [ReservationsController::class, 'store'])->name('admin.reservation.store');
Route::put('/admin/reservation/{id}', [ReservationsController::class, 'update'])->name('admin.reservation.update');
Route::delete('/admin/reservation/{id}', [ReservationsController::class, 'destroy'])->name('admin.reservation.destroy');
