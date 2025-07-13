<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modèle Appointment - Gestion des rendez-vous
 * 
 * @property int $id
 * @property string $prise_en_charge
 * @property string $nom
 * @property string $prenom
 * @property string $civilite
 * @property string $sexe
 * @property \Illuminate\Support\Carbon $date_naissance
 * @property string $lieu_naissance
 * @property string $numero_cmu
 * @property string $nationalite
 * @property string $situation_matrimoniale
 * @property int $nombre_enfants
 * @property string $chez_qui
 * @property string $type_piece
 * @property string $numero_piece
 * @property string $pointure
 * @property string $taille_vetement
 * @property string $premier_choix_formation
 * @property string $deuxieme_choix_formation
 * @property string $troisieme_choix_formation
 * @property string $occupation_actuelle
 * @property string $niveau_actuel
 * @property string $numero_phone
 * @property string $adresse_email
 * @property string $nom_personne_contact
 * @property string $prenom_personne_contact
 * @property string $lien_parente
 * @property string $numero_personne_contact
 * @property \Illuminate\Support\Carbon $date_rdv
 * @property string $creneau_horaire
 * @property int $time_slot_id
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $cancelled_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prise_en_charge',
        'prenom',
        'civilite',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'numero_cmu',
        'nationalite',
        'situation_matrimoniale',
        'nombre_enfants',
        'chez_qui',
        'type_piece',
        'numero_piece',
        'pointure',
        'taille_vetement',
        'premier_choix_formation',
        'deuxieme_choix_formation',
        'troisieme_choix_formation',
        'occupation_actuelle',
        'niveau_actuel',
        'numero_phone',
        'adresse_email',
        'nom_personne_contact',
        'prenom_personne_contact',
        'lien_parente',
        'numero_personne_contact',
        'date_rdv',
        'creneau_horaire',
        'time_slot_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_rdv' => 'date',
        'nombre_enfants' => 'integer',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relation avec le créneau horaire
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Scope pour les rendez-vous confirmés
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope pour les rendez-vous en attente
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les rendez-vous annulés
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope pour une date donnée
     */
    public function scopeForDate(Builder $query, $date): Builder
    {
        return $query->where('date_rdv', $date);
    }

    /**
     * Scope pour aujourd'hui
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('date_rdv', today());
    }

    /**
     * Confirmer le rendez-vous
     */
    public function confirm(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Annuler le rendez-vous
     */
    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        // Décrémenter le nombre de réservations du créneau
        $this->timeSlot->decrementBookings();
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute(): string
    {
        return $this->civilite . ' ' . $this->nom . ' ' . $this->prenom;
    }

    /**
     * Obtenir le nom complet de la personne à contacter
     */
    public function getContactFullNameAttribute(): string
    {
        return $this->nom_personne_contact . ' ' . $this->prenom_personne_contact;
    }

    /**
     * Vérifier si le rendez-vous peut être modifié
     */
    public function canBeModified(): bool
    {
        return $this->status === 'pending' && $this->date_rdv->isFuture();
    }

    /**
     * Obtenir le statut formaté
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'cancelled' => 'Annulé',
            default => 'Inconnu'
        };
    }
}