<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contrôleur web pour les rendez-vous
 */
class AppointmentWebController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    /**
     * Afficher le formulaire de rendez-vous
     */
    public function create()
    {
        return view('forms.appointment');
    }

    /**
     * Traiter la soumission du formulaire
     */
    public function store(StoreAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->appointmentService->createAppointment($request->validated());

            DB::commit();

            return redirect()
                ->route('appointment.success')
                ->with('success', 'Votre rendez-vous a été créé avec succès! Un email de confirmation vous a été envoyé.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }

    /**
     * Afficher la page de succès
     */
    public function success()
    {
        $appointment = Appointment::first(); 
        return view('forms.success', compact('appointment'));
    }
}