<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Web\AppointmentWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\ExportWebController;
use Illuminate\Support\Facades\Route;



// Page d'accueil
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->name('home');

// // Routes pour les rendez-vous
Route::prefix('appointment')->name('appointment.')->group(function () {
    Route::get('/', [AppointmentWebController::class, 'create'])->name('form');
    Route::post('/', [AppointmentWebController::class, 'store'])->name('store');
    Route::get('/success', [AppointmentWebController::class, 'success'])->name('success');
});

// // Routes pour le dashboard (nécessitent une authentification en production)
Route::get('/dashboard', [DashboardWebController::class, 'index'])->name('dashboard');

// // Routes pour les exports
Route::prefix('exports')->name('exports.')->group(function () {
    Route::get('/', [ExportWebController::class, 'index'])->name('index');
    Route::get('/appointments/{appointment}/pdf', [ExportController::class, 'pdf'])->name('pdf');
    Route::get('/excel', [ExportController::class, 'excel'])->name('excel');
});

// // Routes pour l'interface d'administration (à protéger en production)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
    
//     Route::get('/appointments', function () {
//         return view('admin.appointments');
//     })->name('admin.appointments');
    
    Route::get('/timeslots', function () {
        return view('timeslots.index');
    })->name('admin.timeslots.index');
    
//     Route::get('/exports', function () {
//         return view('admin.exports');
//     })->name('admin.exports');
});

// // Routes d'erreur personnalisées
Route::fallback(function () {
    return view('errors.404');
});
