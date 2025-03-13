<?php

use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;


Route::resource('/admin/coupon', CouponController::class)
  ->names('admin.coupon')->middleware('role:concierge');
