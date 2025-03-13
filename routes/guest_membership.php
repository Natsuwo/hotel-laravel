<?php

use App\Http\Controllers\GuestMembershipController;
use Illuminate\Support\Facades\Route;

Route::resource('/admin/guest-membership', GuestMembershipController::class)
  ->names('admin.guest_membership')->middleware('role:concierge');
