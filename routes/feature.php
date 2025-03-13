<?php

use App\Http\Controllers\FeatureController;
use Illuminate\Support\Facades\Route;

Route::resource('/admin/feature', FeatureController::class)->names('admin.feature')->middleware('role:concierge');
