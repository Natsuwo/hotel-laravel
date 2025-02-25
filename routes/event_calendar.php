<?php

use App\Http\Controllers\EventCalendarController;
use Illuminate\Support\Facades\Route;


Route::resource('/admin/event_calendar', EventCalendarController::class)
  ->names('admin.event_calendar');
