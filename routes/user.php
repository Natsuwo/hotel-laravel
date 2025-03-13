<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInviteController;
use App\Http\Controllers\UserMetaController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;


Route::middleware('role:manager')->group(function () {
  Route::resource('roles', RoleController::class)->names('admin.roles');
  Route::resource('user', UserController::class)->names('admin.user');
  Route::resource('user_roles', UserRoleController::class)->names('admin.user_roles');
  Route::resource('user_meta', UserMetaController::class)->names('admin.user_meta');
  Route::resource('user_invite', UserInviteController::class)->names('admin.user_invite');
});
