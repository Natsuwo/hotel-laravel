<?php

use App\Http\Controllers\FeatureController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/feature/index', [FeatureController::class, 'index'])->name('admin.feature.index');
Route::get('/admin/feature/create', [FeatureController::class, 'create'])->name('admin.feature.create');
Route::get('/admin/feature/{id}', [FeatureController::class, 'getById'])->name('admin.feature.show');
Route::get('/admin/feature/{id}/edit', [FeatureController::class, 'edit'])->name('admin.feature.edit');

Route::post('/admin/feature/create', [FeatureController::class, 'store'])->name('admin.feature.store');
Route::put('/admin/feature/{id}', [FeatureController::class, 'update'])->name('admin.feature.update');
Route::delete('/admin/feature/{id}', [FeatureController::class, 'destroy'])->name('admin.feature.destroy');
