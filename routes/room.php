<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;




Route::middleware('role:concierge')->group(function () {
  Route::get('/admin/room/get-room', [RoomController::class, 'getRoom'])->name('admin.room.get-room');
  Route::resource('/admin/room', RoomController::class)->names('admin.room');
});
