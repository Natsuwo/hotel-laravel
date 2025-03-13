<?php

use App\Http\Controllers\RoomTypesController;
use Illuminate\Support\Facades\Route;



Route::middleware('role:concierge')->group(function () {
  Route::get('/admin/room_types/slug', [RoomTypesController::class, 'checkSlug'])->name('admin.room_types.slug');
  Route::get('/admin/room_types/{id}/get', [RoomTypesController::class, 'getRoomById'])->name('admin.room_types.show');
  Route::resource('/admin/room_types', RoomTypesController::class)
    ->names('admin.room_types');
});
