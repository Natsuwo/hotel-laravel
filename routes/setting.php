<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.setting.index');
Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.setting.update');
