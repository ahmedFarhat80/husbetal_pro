<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\doctor\DashbordController;
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
        Route::get('time', ["App\Http\Controllers\doctor\DashbordController", 'TimeView'])->name('time.doctor');
        Route::get('time/timehour/{day}', ["App\Http\Controllers\doctor\DashbordController", 'timehour'])->name('doctor.timehour');
        Route::post('time/timehour/duration/{day}', ["App\Http\Controllers\doctor\DashbordController", 'timehours']);
        Route::put('update-doctor-duration/{id}', ["App\Http\Controllers\doctor\DashbordController", 'Duration']);
        Route::get('booking', ["App\Http\Controllers\doctor\DashbordController", 'booking'])->name('doctor.booking');
        Route::get('invoice/{id}', ["App\Http\Controllers\doctor\DashbordController", 'invoice'])->name('doctor.invoice');
        Route::get('/invoice/dawnlode/{id}', [DashbordController::class, 'downloadInvoice'])->name('doctor.invoice_dawnlode');
    });
});

Route::prefix('doctor/update/profile/')->group(function () {
    Route::get('First-login', [DoctorAuthController::class, 'update_profile'])->middleware('doctor:doctor', 'logs')->name('update.profile');
    Route::post('sendVerification', [DoctorAuthController::class, 'sendVerification'])
        ->middleware('doctor:doctor', 'logs')
        ->name('update.sendVerification');
    Route::get('blocked', [DoctorAuthController::class, 'blocked'])->name('blocked_page');
    // Route::post('re-sendVerification', [DoctorAuthController::class, 'RE_sendVerification'])
    //     ->middleware('doctor:doctor', 'logs')
    //     ->name('re.sendVerification');
    Route::post('resendVerification', [DoctorAuthController::class, 'RE_sendVerification'])
        ->middleware('doctor:doctor', 'logs')
        ->name('re.sendVerification');
    Route::post('ConfirmsendVerification', [DoctorAuthController::class, 'ConfirmsendVerification'])
        ->middleware('doctor:doctor')
        ->name('ConfirmsendVerification');
});
