<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping; // If you need to transform data on the fly

class AppointmentsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $appointmentsData;

    public function __construct(array $appointmentsData)
    {
        $this->appointmentsData = $appointmentsData;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        return $this->appointmentsData;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // These headings must match the keys in the arrays returned by your ExportService's map function
        return [
            'ID',
            'Prise en charge',
            'Nom',
            'Prénom',
            'Civilité',
            'Sexe',
            'Date de naissance',
            'Lieu de naissance',
            'Numéro CMU',
            'Nationalité',
            'Situation matrimoniale',
            'Nombre d\'enfants',
            'Chez qui',
            'Type de pièce',
            'Numéro de pièce',
            'Pointure',
            'Taille vêtement',
            '1er choix formation',
            '2ème choix formation',
            '3ème choix formation',
            'Occupation actuelle',
            'Niveau actuel',
            'Numéro téléphone',
            'Adresse email',
            'Nom personne contact',
            'Prénom personne contact',
            'Lien parenté',
            'Numéro personne contact',
            'Date RDV',
            'Créneau horaire',
            'Statut',
            'Date création'
        ];
    }

    
    /** 
     * Optional: If you need to map data on the fly before it's put into the array,
     * use WithMapping and implement the map method.
     * Example:
     */ 
     public function map($appointment): array{
        return [
            $appointment->id,
            $appointment->prise_en_charge,
            $appointment->nom,
            $appointment->prenom,
            $appointment->civilite,
            $appointment->sexe,
            $appointment->date_naissance->format('d/m/Y'),
            $appointment->lieu_naissance,
            $appointment->numero_cmu,
            $appointment->nationalite,
            $appointment->situation_matrimoniale,
            $appointment->nombre_enfants,
            $appointment->chez_qui,
            $appointment->type_piece,
            $appointment->numero_piece,
            $appointment->pointure,
            $appointment->taille_vetement,
            $appointment->premier_choix_formation,
            $appointment->deuxieme_choix_formation,
            $appointment->troisieme_choix_formation,
            $appointment->occupation_actuelle,
            $appointment->niveau_actuel,
            $appointment->numero_phone,
            $appointment->adresse_email,
            $appointment->nom_personne_contact,
            $appointment->prenom_personne_contact,
            $appointment->lien_parente,
            $appointment->numero_personne_contact,
            $appointment->date_rdv->format('d/m/Y'),
            $appointment->creneau_horaire,
            $appointment->status_label,
            $appointment->created_at->format('d/m/Y H:i')
        ];
     }
     
}