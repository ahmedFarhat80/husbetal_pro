<?php

use App\Http\Controllers\ControllController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Livewire\SectionTable;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

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
        Route::post('admin', [DashboardController::class, 'Store_Admin'])->name('Admin.store');
        Route::put('admin/{id}', [DashboardController::class, 'Update_Admin'])->name('Admin.update');
        Route::delete('admin/{id}', [DashboardController::class, 'destroy_Admin'])->name('Admin.delete');

        Route::get('doctor', [DashboardController::class, 'index_Doctor'])->name('doctor');
        Route::post('doctor/create', [DashboardController::class, 'index_Doctor_Create'])->name('doctor.create');
        Route::get('doctor/edit/{id}', [DashboardController::class, 'Edit_Doctor'])->name('doctor.Edit');
        Route::put('doctor/update/{id}', [DashboardController::class, 'update_Doctor'])->name('doctor.update');
        Route::put('update-doctor-status/{id}', [DashboardController::class, 'doctor_status']);
        Route::delete('doctor/delete/{id}', [DashboardController::class, 'doctor_delete']);

        Route::get('Section', [DashboardController::class, 'index_Section'])->name('Section');
        Route::get('Section/{id}', [DashboardController::class, 'getSectionById']);
        Route::post('Section', [DashboardController::class, 'addSection'])->name('dashboard.addSection');
        Route::put('Section/{id}', [DashboardController::class, 'updateSection']);
        Route::delete('Section/delete/{id}', [DashboardController::class, 'destroy_Section']);
        Route::get('booking', [DashboardController::class, 'booking'])->name('booking');
        Route::post('/delete-rows', [DashboardController::class, 'deleteRows_booking'])->name('delete.rows');

        Route::get('Complaints', [DashboardController::class, 'Complaints'])->name('Complaints');
        Route::get('Complaint/view/{id}', [DashboardController::class, 'Complaint_view'])->name('Complaint.view');
        Route::delete('Complaints/{id}', [DashboardController::class, 'Complaints_delete'])->name('Complaints.delete');
        Route::post('export-to-pdf', [DashboardController::class, 'PDF_Export'])->name('export.pdf');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles.permissions', RolePermissionController::class);
        Route::post('/assign-role', [RoleController::class, 'assignRole'])->name('assign.role');
    });
});


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
    Route::post('dateSelct_ok', [ControllController::class, 'dateSelct_ok']);
    Route::get('time', [ControllController::class, 'TimeSelct']);
    Route::post('time', [ControllController::class, 'time']);
    Route::get('data_info', [ControllController::class, 'data_info']);
    Route::post('data_info', [ControllController::class, 'data_info_store']);
    Route::get('booking-summary', [ControllController::class, 'booking_summary']);
    Route::post('booking-summary', [ControllController::class, 'booking_summary_store']);
    Route::get('booking-success/{random}', [ControllController::class, 'booking_success']);
    Route::get('Complaints', [ControllController::class, 'Complaints'])->name('complaints');
    Route::post('fetch-doctors', [ControllController::class, 'fetchDoctors'])->name('fetch.doctors');
    Route::post('Complaints', [ControllController::class, 'Complaints_done']);
});
