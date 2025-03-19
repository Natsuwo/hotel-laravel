<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::guard('web')->check()) {
        return redirect()->route('admin.reservation.index');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');


require __DIR__ . '/auth.php';
require __DIR__ . '/gallery.php';
require __DIR__ . '/room_types.php';
require __DIR__ . '/room.php';
require __DIR__ . '/floor.php';
require __DIR__ . '/feature.php';
require __DIR__ . '/reservation.php';
require __DIR__ . '/guest.php';
require __DIR__ . '/guest_membership.php';
require __DIR__ . '/housekeeping.php';
require __DIR__ . '/invoice.php';
require __DIR__ . '/event_calendar.php';
require __DIR__ . '/inventory.php';
require __DIR__ . '/setting.php';
require __DIR__ . '/message.php';
require __DIR__ . '/blog.php';
require __DIR__ . '/coupon.php';
require __DIR__ . '/user.php';
