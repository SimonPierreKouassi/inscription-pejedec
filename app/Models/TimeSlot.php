<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle TimeSlot - Gestion des créneaux horaires
 * 
 * @property int $id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property int $max_capacity
 * @property int $current_bookings
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'max_capacity',
        'current_bookings',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les rendez-vous
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope pour les créneaux disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                    ->whereRaw('current_bookings < max_capacity');
    }

    /**
     * Scope pour une date donnée
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    /**
     * Vérifier si le créneau est disponible
     */
    public function isAvailable(): bool
    {
        return $this->is_active && $this->current_bookings < $this->max_capacity;
    }

    /**
     * Obtenir le nombre de places restantes
     */
    public function getRemainingCapacityAttribute(): int
    {
        return $this->max_capacity - $this->current_bookings;
    }

    /**
     * Incrémenter le nombre de réservations
     */
    public function incrementBookings(): void
    {
        $this->increment('current_bookings');
    }

    /**
     * Décrémenter le nombre de réservations
     */
    public function decrementBookings(): void
    {
        $this->decrement('current_bookings');
    }

    /**
     * Formater l'heure pour l'affichage
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}