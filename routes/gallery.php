<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/admin/gallery/index', [GalleryController::class, 'index'])->name('admin.gallery.index');
Route::post('/admin/gallery/upload', [GalleryController::class, 'upload'])->name('admin.gallery.upload');
Route::delete('/admin/gallery/delete', [GalleryController::class, 'delete'])->name('admin.gallery.delete');
Route::get('/admin/gallery/search', [GalleryController::class, 'search'])->name('admin.gallery.search');
Route::get('/admin/gallery/modal', [GalleryController::class, 'modal'])->name('admin.gallery.modal');
