<?php

use App\Http\Controllers\GuestMembershipController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/guest-membership/index', [GuestMembershipController::class, 'index'])->name('admin.guest_membership.index');
Route::get('/admin/guest-membership/create', [GuestMembershipController::class, 'create'])->name('admin.guest_membership.create');
Route::get('/admin/guest-membership/{id}/edit', [GuestMembershipController::class, 'edit'])->name('admin.guest_membership.edit');

Route::post('/admin/guest-membership/store', [GuestMembershipController::class, 'store'])->name('admin.guest_membership.store');
Route::put('/admin/guest-membership/{id}', [GuestMembershipController::class, 'update'])->name('admin.guest_membership.update');
Route::delete('/admin/guest-membership/{id}', [GuestMembershipController::class, 'destroy'])->name('admin.guest_membership.destroy');
