<?php

use App\Http\Controllers\FacilityController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/facility/index', [FacilityController::class, 'index'])->name('admin.facility.index');
Route::get('/admin/facility/create', [FacilityController::class, 'create'])->name('admin.facility.create');
Route::get('/admin/facility/{id}', [FacilityController::class, 'getById'])->name('admin.facility.show');
Route::get('/admin/facility/{id}/edit', [FacilityController::class, 'edit'])->name('admin.facility.edit');

Route::post('/admin/facility/create', [FacilityController::class, 'store'])->name('admin.facility.store');
Route::put('/admin/facility/{id}', [FacilityController::class, 'update'])->name('admin.facility.update');
Route::delete('/admin/facility/{id}', [FacilityController::class, 'destroy'])->name('admin.facility.destroy');
