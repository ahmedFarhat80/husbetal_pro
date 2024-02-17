<?php

use App\Http\Controllers\ControllController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReservationsController;
use App\Livewire\SectionTable;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware([
    'lang',
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        Route::get('Admin', [DashboardController::class, 'index_Admin'])->name('Admin');
        Route::get('doctor', [DashboardController::class, 'index_Doctor'])->name('doctor');
        Route::post('doctor/create', [DashboardController::class, 'index_Doctor_Create'])->name('doctor.create');
        Route::get('Section', [DashboardController::class, 'index_Section'])->name('Section');
        Route::get('Section/{id}', [DashboardController::class, 'getSectionById']);
        Route::post('Section', [DashboardController::class, 'addSection'])->name('dashboard.addSection');
        Route::put('Section/{id}', [DashboardController::class, 'updateSection']);
        Route::delete('Section/delete/{id}', [DashboardController::class, 'destroy_Section']);
    });
});


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



Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['ar', 'en'])) {
        if (session()->has('lang')) {
            session()->forget('lang');
        }
        session()->put('lang', $lang);
    } else {
        if (session()->has('lang')) {
            session()->forget('lang');
        }
        session()->put('lang', 'ar');
    }
    return back();
})->name('lang');


Route::prefix('/')->middleware('lang')->group(function () {
    Route::resources(['/' => ReservationsController::class]);
    Route::resources(['/doctor' => DoctorController::class]);
    Route::get('date', [ControllController::class, 'dateSelct']);
});
