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

Route::prefix('appointments')->group(function () {
    Route::post('/', [AppointmentController::class, 'store'])->name('appointment.create');
});

Route::prefix('timeslots')->group(function () {
    Route::get('/available', [TimeSlotController::class, 'available'])->name('timeslots.available');
    Route::get('/appointments/{appointment}/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
    Route::get('/for-date', [TimeSlotController::class, 'forDate'])->name('timeslots.date');
    Route::get('/', [TimeSlotController::class, 'index']);
    Route::post('/', [TimeSlotController::class, 'store']);
    Route::post('/generate', [TimeSlotController::class, 'generate']);
    Route::get('/{timeSlot}', [TimeSlotController::class, 'show']);
    Route::put('/{timeSlot}', [TimeSlotController::class, 'update']);
    Route::patch('/{timeSlot}/toggle', [TimeSlotController::class, 'toggleStatus']);
    Route::delete('/{timeSlot}', [TimeSlotController::class, 'destroy']);
});

// Routes protégées (nécessitent une authentification)
// Route::middleware('auth:sanctum')->group(function () {
    // Routes administrateur
    // Route::middleware('role:admin')->group(function () {
        // Gestion des utilisateurs, configuration, etc.
        // Routes publiques pour les rendez-vous
        Route::prefix('appointments')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('appointment.index');
            Route::post('/', [AppointmentController::class, 'store'])->name('appointment.create');
            Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('appointment.show');
            Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('appointment.update');
            Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
            
            // Actions spécifiques
            Route::patch('/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointment.confirm');
            Route::patch('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
            Route::post('/bulk-action', [AppointmentController::class, 'bulkAction'])->name('appointment.bulk');
            Route::get('/stats/dashboard', [AppointmentController::class, 'stats'])->name('appointment.stats');
        });

        // Routes pour les créneaux horaires
        Route::prefix('timeslots')->group(function () {
            Route::post('/generate', [TimeSlotController::class, 'generate'])->name('timeslots.generate');
        });
    // });
// });