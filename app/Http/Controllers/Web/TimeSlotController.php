<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Contrôleur administrateur pour la gestion des créneaux horaires
 */
class TimeSlotController extends Controller
{
    /**
     * Afficher la page de gestion des créneaux
     */
    public function index()
    {
        return view('admin.timeslots.index');
    }

    /**
     * Créer un nouveau créneau
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:1|max:50',
            'is_active' => 'boolean'
        ]);

        // Vérifier qu'il n'y a pas de conflit d'horaires
        $existing = TimeSlot::where('date', $request->date)
                           ->where(function ($query) use ($request) {
                               $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                     ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                                     ->orWhere(function ($q) use ($request) {
                                         $q->where('start_time', '<=', $request->start_time)
                                           ->where('end_time', '>=', $request->end_time);
                                     });
                           })
                           ->exists();

        if ($existing) {
            return response()->json([
                'message' => 'Un créneau existe déjà sur cette plage horaire'
            ], 422);
        }

        $timeSlot = TimeSlot::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_capacity' => $request->max_capacity,
            'current_bookings' => 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json([
            'message' => 'Créneau créé avec succès',
            'time_slot' => $timeSlot
        ], 201);
    }

    /**
     * Mettre à jour un créneau
     */
    public function update(Request $request, TimeSlot $timeSlot): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:1|max:50',
            'is_active' => 'boolean'
        ]);

        // Vérifier que la nouvelle capacité n'est pas inférieure aux réservations actuelles
        if ($request->max_capacity < $timeSlot->current_bookings) {
            return response()->json([
                'message' => 'La capacité ne peut pas être inférieure au nombre de réservations actuelles (' . $timeSlot->current_bookings . ')'
            ], 422);
        }

        // Vérifier qu'il n'y a pas de conflit d'horaires (sauf avec lui-même)
        $existing = TimeSlot::where('date', $request->date)
                           ->where('id', '!=', $timeSlot->id)
                           ->where(function ($query) use ($request) {
                               $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                     ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                                     ->orWhere(function ($q) use ($request) {
                                         $q->where('start_time', '<=', $request->start_time)
                                           ->where('end_time', '>=', $request->end_time);
                                     });
                           })
                           ->exists();

        if ($existing) {
            return response()->json([
                'message' => 'Un créneau existe déjà sur cette plage horaire'
            ], 422);
        }

        $timeSlot->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_capacity' => $request->max_capacity,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json([
            'message' => 'Créneau mis à jour avec succès',
            'time_slot' => $timeSlot
        ]);
    }

    /**
     * Supprimer un créneau
     */
    public function destroy(TimeSlot $timeSlot): JsonResponse
    {
        // Vérifier qu'il n'y a pas de réservations
        if ($timeSlot->current_bookings > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer un créneau avec des réservations'
            ], 422);
        }

        $timeSlot->delete();

        return response()->json([
            'message' => 'Créneau supprimé avec succès'
        ]);
    }

    /**
     * Basculer le statut actif/inactif d'un créneau
     */
    public function toggle(TimeSlot $timeSlot): JsonResponse
    {
        $timeSlot->update([
            'is_active' => !$timeSlot->is_active
        ]);

        $status = $timeSlot->is_active ? 'activé' : 'désactivé';

        return response()->json([
            'message' => "Créneau {$status} avec succès",
            'time_slot' => $timeSlot
        ]);
    }

    /**
     * Générer des créneaux en masse
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'capacity' => 'required|integer|min:1|max:50'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $capacity = $request->capacity;
        $created = 0;

        // Créneaux par défaut (8h-12h et 14h-18h)
        $defaultSlots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['11:00', '12:00'],
            ['14:00', '15:00'],
            ['15:00', '16:00'],
            ['16:00', '17:00'],
            ['17:00', '18:00'],
        ];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Ignorer les weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($defaultSlots as $slot) {
                // Vérifier si le créneau existe déjà
                $existing = TimeSlot::where('date', $date->format('Y-m-d'))
                                  ->where('start_time', $slot[0])
                                  ->where('end_time', $slot[1])
                                  ->exists();

                if (!$existing) {
                    TimeSlot::create([
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slot[0],
                        'end_time' => $slot[1],
                        'max_capacity' => $capacity,
                        'current_bookings' => 0,
                        'is_active' => true,
                    ]);
                    $created++;
                }
            }
        }

        return response()->json([
            'message' => "{$created} créneaux générés avec succès"
        ]);
    }

    /**
     * Obtenir les statistiques des créneaux
     */
    public function stats(): JsonResponse
    {
        $total = TimeSlot::count();
        $available = TimeSlot::available()->count();
        $full = TimeSlot::whereRaw('current_bookings >= max_capacity')->count();
        $inactive = TimeSlot::where('is_active', false)->count();

        return response()->json([
            'total' => $total,
            'available' => $available,
            'full' => $full,
            'inactive' => $inactive
        ]);
    }
}