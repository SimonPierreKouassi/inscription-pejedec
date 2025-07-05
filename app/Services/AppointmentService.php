<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Service pour la gestion des rendez-vous
 */
class AppointmentService
{
    /**
     * Créer un nouveau rendez-vous
     */
    public function createAppointment(array $data): Appointment
    {
        // Vérifier la disponibilité du créneau
        $timeSlot = TimeSlot::find($data['time_slot_id']);
        
        if (!$timeSlot || !$timeSlot->isAvailable()) {
            throw new \Exception('Le créneau sélectionné n\'est plus disponible.');
        }

        // Créer le rendez-vous
        $appointment = Appointment::create($data);

        // Incrémenter le nombre de réservations du créneau
        $timeSlot->incrementBookings();

        // Envoyer l'email de confirmation (optionnel)
        // $this->sendConfirmationEmail($appointment);

        return $appointment;
    }

    /**
     * Mettre à jour un rendez-vous
     */
    public function updateAppointment(Appointment $appointment, array $data): Appointment
    {
        // Si le créneau change, gérer la disponibilité
        if (isset($data['time_slot_id']) && $data['time_slot_id'] !== $appointment->time_slot_id) {
            $oldTimeSlot = $appointment->timeSlot;
            $newTimeSlot = TimeSlot::find($data['time_slot_id']);

            if (!$newTimeSlot || !$newTimeSlot->isAvailable()) {
                throw new \Exception('Le nouveau créneau sélectionné n\'est pas disponible.');
            }

            // Décrémenter l'ancien créneau et incrémenter le nouveau
            $oldTimeSlot->decrementBookings();
            $newTimeSlot->incrementBookings();
        }

        $appointment->update($data);

        return $appointment->fresh();
    }

    /**
     * Supprimer un rendez-vous
     */
    public function deleteAppointment(Appointment $appointment): void
    {
        // Décrémenter le nombre de réservations du créneau
        $appointment->timeSlot->decrementBookings();

        $appointment->delete();
    }

    /**
     * Envoyer l'email de confirmation
     */
    private function sendConfirmationEmail(Appointment $appointment): void
    {
        // Implémentation de l'envoi d'email
        // Mail::to($appointment->adresse_email)->send(new AppointmentConfirmation($appointment));
    }

    /**
     * Obtenir les statistiques des rendez-vous
     */
    public function getStats(): array
    {
        return [
            'total' => Appointment::count(),
            'confirmed' => Appointment::confirmed()->count(),
            'pending' => Appointment::pending()->count(),
            'cancelled' => Appointment::cancelled()->count(),
            'today' => Appointment::today()->count(),
            'by_formation' => Appointment::selectRaw('premier_choix_formation, COUNT(*) as count')
                                       ->groupBy('premier_choix_formation')
                                       ->get()
                                       ->pluck('count', 'premier_choix_formation'),
            'by_status' => Appointment::selectRaw('status, COUNT(*) as count')
                                    ->groupBy('status')
                                    ->get()
                                    ->pluck('count', 'status'),
        ];
    }

    /**
     * Rechercher des rendez-vous
     */
    public function searchAppointments(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Appointment::where('nom', 'like', "%{$query}%")
                         ->orWhere('prenom', 'like', "%{$query}%")
                         ->orWhere('adresse_email', 'like', "%{$query}%")
                         ->orWhere('numero_phone', 'like', "%{$query}%")
                         ->with('timeSlot')
                         ->orderBy('date_rdv', 'desc')
                         ->get();
    }
}