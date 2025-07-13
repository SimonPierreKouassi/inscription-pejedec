<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contrôleur pour la gestion des rendez-vous
 */
class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    /**
     * Afficher la liste des rendez-vous
     */
    public function index(Request $request): JsonResponse
    {
        $query = Appointment::with('timeSlot');

        // Filtres
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

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('adresse_email', 'like', "%{$search}%")
                  ->orWhere('numero_phone', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('date_rdv', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        return response()->json($appointments);
    }

    /**
     * Créer un nouveau rendez-vous
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $appointment = $this->appointmentService->createAppointment($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'Rendez-vous créé avec succès',
                'appointment' => $appointment->load('timeSlot')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Erreur lors de la création du rendez-vous',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Afficher un rendez-vous spécifique
     */
    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json($appointment->load('timeSlot'));
    }

    /**
     * Mettre à jour un rendez-vous
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        try {
            DB::beginTransaction();

            $updatedAppointment = $this->appointmentService->updateAppointment(
                $appointment, 
                $request->validated()
            );

            DB::commit();

            return response()->json([
                'message' => 'Rendez-vous mis à jour avec succès',
                'appointment' => $updatedAppointment->load('timeSlot')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Supprimer un rendez-vous
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        try {
            DB::beginTransaction();

            $this->appointmentService->deleteAppointment($appointment);

            DB::commit();

            return response()->json([
                'message' => 'Rendez-vous supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Confirmer un rendez-vous
     */
    public function confirm(Appointment $appointment): JsonResponse
    {
        $appointment->confirm();

        return response()->json([
            'message' => 'Rendez-vous confirmé avec succès',
            'appointment' => $appointment->load('timeSlot')
        ]);
    }

    /**
     * Annuler un rendez-vous
     */
    public function cancel(Appointment $appointment): JsonResponse
    {
        $appointment->cancel();

        return response()->json([
            'message' => 'Rendez-vous annulé avec succès',
            'appointment' => $appointment->load('timeSlot')
        ]);
    }

    /**
     * Actions en masse
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:confirmed,cancelled,delete',
            'appointment_ids' => 'required|array',
            'appointment_ids.*' => 'exists:appointments,id'
        ]);

        try {
            DB::beginTransaction();

            $appointments = Appointment::whereIn('id', $request->appointment_ids)->get();
            $count = 0;

            foreach ($appointments as $appointment) {
                switch ($request->action) {
                    case 'confirmed':
                        if ($appointment->status === 'pending') {
                            $appointment->confirm();
                            $count++;
                        }
                        break;
                    case 'cancelled':
                        if ($appointment->status !== 'cancelled') {
                            $appointment->cancel();
                            $count++;
                        }
                        break;
                    case 'delete':
                        $this->appointmentService->deleteAppointment($appointment);
                        $count++;
                        break;
                }
            }

            DB::commit();

            return response()->json([
                'message' => "Action effectuée sur {$count} rendez-vous"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Erreur lors de l\'action en masse',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Obtenir les statistiques
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'confirmed_appointments' => Appointment::confirmed()->count(),
            'pending_appointments' => Appointment::pending()->count(),
            'cancelled_appointments' => Appointment::cancelled()->count(),
            'today_appointments' => Appointment::today()->count(),
        ];

        return response()->json($stats);
    }
}