<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Requête de validation pour la création d'un rendez-vous
 */
class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Informations personnelles
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'civilite' => 'required|in:MR,Mme',
            'sexe' => 'required|in:homme,femme',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'required|string|max:255',
            'numero_cmu' => 'required|string|max:255',
            'nationalite' => 'required|in:ivoirienne,etrangere',
            'situation_matrimoniale' => 'required|in:celibataire,marie',
            'nombre_enfants' => 'required|integer|min:0',
            'chez_qui' => 'required|in:pere,mere,grand-mere',
            
            // Pièces d'identité
            'type_piece' => 'required|in:CNI,passeport',
            'numero_piece' => 'required|string|max:255|unique:appointments,numero_piece',
            
            // Informations physiques
            'pointure' => 'required|string|max:10',
            'taille_vetement' => 'required|string|max:10',
            
            // Formations
            'premier_choix_formation' => 'required|in:formation A,formation B',
            'deuxieme_choix_formation' => 'required|in:formation A,formation B',
            'troisieme_choix_formation' => 'required|in:formation A,formation B',
            
            // Informations académiques/professionnelles
            'occupation_actuelle' => 'required|string|max:255',
            'niveau_actuel' => 'required|in:primaire,college,lycee',
            
            // Contact
            'numero_phone' => 'required|string|max:20',
            'adresse_email' => 'required|email|max:255|unique:appointments,adresse_email',
            
            // Personne à contacter
            'nom_personne_contact' => 'required|string|max:255',
            'prenom_personne_contact' => 'required|string|max:255',
            'lien_parente' => 'required|in:pere,simple',
            'numero_personne_contact' => 'required|string|max:20',
            
            // Rendez-vous
            'date_rdv' => [
                'required',
                'date',
                'after_or_equal:2024-07-07',
                'after_or_equal:today'
            ],
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                Rule::exists('time_slots', 'id')->where(function ($query) {
                    $query->where('is_active', true)
                          ->whereRaw('current_bookings < max_capacity');
                })
            ],
            
            // Optionnel
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'numero_piece.unique' => 'Ce numéro de pièce d\'identité est déjà utilisé.',
            'adresse_email.unique' => 'Cette adresse email est déjà utilisée.',
            'date_rdv.after_or_equal' => 'La date de rendez-vous doit être à partir du 7 juillet 2024.',
            'time_slot_id.exists' => 'Le créneau sélectionné n\'est pas disponible.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Calculer le créneau horaire à partir du time_slot_id
        if ($this->has('time_slot_id')) {
            $timeSlot = \App\Models\TimeSlot::find($this->time_slot_id);
            if ($timeSlot) {
                $this->merge([
                    'creneau_horaire' => $timeSlot->formatted_time
                ]);
            }
        }
    }
}