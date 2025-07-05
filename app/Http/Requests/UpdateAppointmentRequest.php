<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Requête de validation pour la mise à jour d'un rendez-vous
 */
class UpdateAppointmentRequest extends FormRequest
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
        $appointmentId = $this->route('appointment')->id;

        return [
            // Informations personnelles
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'civilite' => 'sometimes|required|in:MR,Mme',
            'sexe' => 'sometimes|required|in:homme,femme',
            'date_naissance' => 'sometimes|required|date|before:today',
            'lieu_naissance' => 'sometimes|required|string|max:255',
            'numero_cmu' => 'sometimes|required|string|max:255',
            'nationalite' => 'sometimes|required|in:ivoirienne,etrangere',
            'situation_matrimoniale' => 'sometimes|required|in:celibataire,marie',
            'nombre_enfants' => 'sometimes|required|integer|min:0',
            'chez_qui' => 'sometimes|required|in:pere,mere,grand-mere',
            
            // Pièces d'identité
            'type_piece' => 'sometimes|required|in:CNI,passeport',
            'numero_piece' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('appointments', 'numero_piece')->ignore($appointmentId)
            ],
            
            // Informations physiques
            'pointure' => 'sometimes|required|string|max:10',
            'taille_vetement' => 'sometimes|required|string|max:10',
            
            // Formations
            'premier_choix_formation' => 'sometimes|required|in:formation A,formation B',
            'deuxieme_choix_formation' => 'sometimes|required|in:formation A,formation B',
            'troisieme_choix_formation' => 'sometimes|required|in:formation A,formation B',
            
            // Informations académiques/professionnelles
            'occupation_actuelle' => 'sometimes|required|string|max:255',
            'niveau_actuel' => 'sometimes|required|in:primaire,college,lycee',
            
            // Contact
            'numero_phone' => 'sometimes|required|string|max:20',
            'adresse_email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('appointments', 'adresse_email')->ignore($appointmentId)
            ],
            
            // Personne à contacter
            'nom_personne_contact' => 'sometimes|required|string|max:255',
            'prenom_personne_contact' => 'sometimes|required|string|max:255',
            'lien_parente' => 'sometimes|required|in:pere,simple',
            'numero_personne_contact' => 'sometimes|required|string|max:20',
            
            // Rendez-vous
            'date_rdv' => [
                'sometimes',
                'required',
                'date',
                'after_or_equal:2024-07-07',
                'after_or_equal:today'
            ],
            'time_slot_id' => [
                'sometimes',
                'required',
                'exists:time_slots,id',
                Rule::exists('time_slots', 'id')->where(function ($query) {
                    $query->where('is_active', true)
                          ->whereRaw('current_bookings < max_capacity');
                })
            ],
            
            // Statut et notes
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'numero_piece.unique' => 'Ce numéro de pièce d\'identité est déjà utilisé.',
            'adresse_email.unique' => 'Cette adresse email est déjà utilisée.',
            'date_rdv.after_or_equal' => 'La date de rendez-vous doit être à partir du 7 juillet 2024.',
            'time_slot_id.exists' => 'Le créneau sélectionné n\'est pas disponible.',
        ];
    }
}