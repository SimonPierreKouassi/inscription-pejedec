<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Contrôleur pour les exports
 */
class ExportController extends Controller
{
    public function __construct(
        private ExportService $exportService
    ) {}

    /**
     * Exporter les rendez-vous en Excel
     */
    public function excel(Request $request): Response
    {
        $query = Appointment::with('timeSlot');

        // Appliquer les filtres
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->where('date_rdv', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('date_rdv', '<=', $request->date_to);
        }

        if ($request->has('formation')) {
            $query->where(function ($q) use ($request) {
                $q->where('premier_choix_formation', $request->formation)
                  ->orWhere('deuxieme_choix_formation', $request->formation)
                  ->orWhere('troisieme_choix_formation', $request->formation);
            });
        }

        $appointments = $query->orderBy('date_rdv', 'desc')->get();

        return $this->exportService->exportToExcel($appointments);
    }

    /**
     * Générer un PDF pour un rendez-vous
     */
    public function pdf(Appointment $appointment): Response
    {
        return $this->exportService->generatePDF($appointment);
    }

    /**
     * Exporter les statistiques
     */
    public function stats(): Response
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'confirmed_appointments' => Appointment::confirmed()->count(),
            'pending_appointments' => Appointment::pending()->count(),
            'cancelled_appointments' => Appointment::cancelled()->count(),
            'today_appointments' => Appointment::today()->count(),
            'by_formation' => Appointment::selectRaw('premier_choix_formation, COUNT(*) as count')
                                       ->groupBy('premier_choix_formation')
                                       ->get(),
            'by_status' => Appointment::selectRaw('status, COUNT(*) as count')
                                    ->groupBy('status')
                                    ->get(),
        ];

        return $this->exportService->exportStatsToExcel($stats);
    }
}