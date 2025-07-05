<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes publiques pour les rendez-vous
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::post('/', [AppointmentController::class, 'store']);
    Route::get('/{appointment}', [AppointmentController::class, 'show']);
    Route::put('/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/{appointment}', [AppointmentController::class, 'destroy']);
    
    // Actions spécifiques
    Route::patch('/{appointment}/confirm', [AppointmentController::class, 'confirm']);
    Route::patch('/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    Route::post('/bulk-action', [AppointmentController::class, 'bulkAction']);
    Route::get('/stats/dashboard', [AppointmentController::class, 'stats']);
});

// Routes pour les créneaux horaires
Route::prefix('time-slots')->group(function () {
    Route::get('/available', [TimeSlotController::class, 'available']);
    Route::get('/for-date', [TimeSlotController::class, 'forDate']);
    Route::post('/generate', [TimeSlotController::class, 'generate']);
});

// Routes pour les exports
Route::prefix('exports')->group(function () {
    Route::get('/excel', [ExportController::class, 'excel']);
    Route::get('/appointments/{appointment}/pdf', [ExportController::class, 'pdf']);
    Route::get('/stats', [ExportController::class, 'stats']);
});

// Routes protégées (nécessitent une authentification)
Route::middleware('auth:sanctum')->group(function () {
    // Routes administrateur
    Route::middleware('role:admin')->group(function () {
        // Gestion des utilisateurs, configuration, etc.
    });
});