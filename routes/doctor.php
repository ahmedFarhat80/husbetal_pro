<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:doctor')->group(function () {
    Route::get('doctor/login', [DoctorAuthController::class, 'loginForm']);
    Route::post('doctor/login', [DoctorAuthController::class, 'store'])->name('doctor.login');
});


Route::middleware([
    'lang',
    'auth:sanctum,doctor', config('jetstream.auth_session'), 'verified',
])->group(function () {
    Route::get('doctor/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('doctor/dashboard')->group(function () {
        Route::get('Admin', [DashboardController::class, 'index_Admin'])->name('Admin');
    });
});


Route::get('doctor/update/profile/First-login', [DoctorAuthController::class, 'update_profile'])->middleware('doctor:doctor', 'logs')->name('update.profile');
Route::get('doctor/update/profile/sendVerification', [DoctorAuthController::class, 'sendVerification'])
    ->middleware('doctor:doctor', 'logs')
    ->name('update.sendVerification');
Route::get('blocked', [DoctorAuthController::class, 'blocked'])->name('blocked_page');
Route::post('doctor/update/profile/re-sendVerification', [DoctorAuthController::class, 'RE_sendVerification'])
    ->middleware('doctor:doctor', 'logs')
    ->name('re.sendVerification');
Route::post('doctor/update/profile/ConfirmsendVerification', [DoctorAuthController::class, 'ConfirmsendVerification'])
    ->middleware('doctor:doctor')
    ->name('ConfirmsendVerification');
