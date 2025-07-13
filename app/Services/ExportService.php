<?php

namespace App\Services;

use App\Exports\AppointmentsExport;
use App\Exports\StatsExport;
use App\Models\Appointment;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Service pour les exports
 */
class ExportService
{
    /**
     * Exporter les rendez-vous en Excel
     */
    public function exportToExcel($appointments)
    {
        $data = $appointments->map(function ($appointment) {
            return [
                'ID' => $appointment->id,
                'Prise en charge' => $appointment->prise_en_charge,
                'Nom' => $appointment->nom,
                'Prénom' => $appointment->prenom,
                'Civilité' => $appointment->civilite,
                'Sexe' => $appointment->sexe,
                'Date de naissance' => $appointment->date_naissance->format('d/m/Y'),
                'Lieu de naissance' => $appointment->lieu_naissance,
                'Numéro CMU' => $appointment->numero_cmu,
                'Nationalité' => $appointment->nationalite,
                'Situation matrimoniale' => $appointment->situation_matrimoniale,
                'Nombre d\'enfants' => $appointment->nombre_enfants,
                'Chez qui' => $appointment->chez_qui,
                'Type de pièce' => $appointment->type_piece,
                'Numéro de pièce' => $appointment->numero_piece,
                'Pointure' => $appointment->pointure,
                'Taille vêtement' => $appointment->taille_vetement,
                '1er choix formation' => $appointment->premier_choix_formation,
                '2ème choix formation' => $appointment->deuxieme_choix_formation,
                '3ème choix formation' => $appointment->troisieme_choix_formation,
                'Occupation actuelle' => $appointment->occupation_actuelle,
                'Niveau actuel' => $appointment->niveau_actuel,
                'Numéro téléphone' => $appointment->numero_phone,
                'Adresse email' => $appointment->adresse_email,
                'Nom personne contact' => $appointment->nom_personne_contact,
                'Prénom personne contact' => $appointment->prenom_personne_contact,
                'Lien parenté' => $appointment->lien_parente,
                'Numéro personne contact' => $appointment->numero_personne_contact,
                'Date RDV' => $appointment->date_rdv->format('d/m/Y'),
                'Créneau horaire' => $appointment->creneau_horaire,
                'Statut' => $appointment->status_label,
                'Date création' => $appointment->created_at->format('d/m/Y H:i'),
            ];
        })->toArray();

        return Excel::download(
            new AppointmentsExport($data),
            'rendez-vous-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Générer un PDF pour un rendez-vous
     */
    public function generatePDF(Appointment $appointment): Response
    {
        $pdf = Pdf::loadView('exports.appointment-pdf', compact('appointment'));
        
        return $pdf->download(
            'rendez-vous-' . $appointment->nom . '-' . $appointment->prenom . '.pdf'
        );
    }

    /**
     * Exporter les statistiques en Excel
     */
    public function exportStatsToExcel(array $stats)
    {
        $data = [
            ['Statistique', 'Valeur'],
            ['Total des rendez-vous', $stats['total_appointments']],
            ['Rendez-vous confirmés', $stats['confirmed_appointments']],
            ['Rendez-vous en attente', $stats['pending_appointments']],
            ['Rendez-vous annulés', $stats['cancelled_appointments']],
            ['Rendez-vous aujourd\'hui', $stats['today_appointments']],
        ];

        // Ajouter les statistiques par formation
        $data[] = ['', ''];
        $data[] = ['Répartition par formation', ''];
        foreach ($stats['by_formation'] as $formation) {
            $data[] = [$formation->premier_choix_formation, $formation->count];
        }

        // Ajouter les statistiques par statut
        $data[] = ['', ''];
        $data[] = ['Répartition par statut', ''];
        foreach ($stats['by_status'] as $status) {
            $data[] = [$status->status, $status->count];
        }

        return Excel::download(
            new StatsExport($data),
            'statistiques-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}