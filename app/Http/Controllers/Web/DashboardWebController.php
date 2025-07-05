<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;

/**
 * Contrôleur web pour le dashboard
 */
class DashboardWebController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    /**
     * Afficher le dashboard
     */
    public function index()
    {
        $appointments = Appointment::with('timeSlot')
                                 ->orderBy('date_rdv', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(50)
                                 ->get();

        $stats = $this->appointmentService->getStats();

        return view('dashboard.index', compact('appointments', 'stats'));
    }
}