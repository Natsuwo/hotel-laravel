<?php

use App\Http\Controllers\FloorController;
use Illuminate\Support\Facades\Route;

Route::resource('/admin/floor', FloorController::class)
  ->names('admin.floor')->middleware('role:concierge');
