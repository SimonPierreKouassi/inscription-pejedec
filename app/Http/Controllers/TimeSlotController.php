<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Contrôleur pour la gestion des créneaux horaires
 */
class TimeSlotController extends Controller
{
    /**
     * Obtenir les créneaux disponibles
     */
    public function available(Request $request): JsonResponse
    {
        $query = TimeSlot::available();

        // Filtrer par date si spécifiée
        if ($request->has('date')) {
            $query->forDate($request->date);
        } else {
            // Par défaut, à partir d'aujourd'hui
            $query->where('date', '>=', today());
        }

        $timeSlots = $query->orderBy('date')
                          ->orderBy('start_time')
                          ->get()
                          ->map(function ($slot) {
                              return [
                                  'id' => $slot->id,
                                  'date' => $slot->date->format('Y-m-d'),
                                  'start_time' => $slot->start_time->format('H:i'),
                                  'end_time' => $slot->end_time->format('H:i'),
                                  'formatted_time' => $slot->formatted_time,
                                  'max_capacity' => $slot->max_capacity,
                                  'current_bookings' => $slot->current_bookings,
                                  'remaining_capacity' => $slot->remaining_capacity,
                                  'is_available' => $slot->isAvailable(),
                              ];
                          });

        return response()->json($timeSlots);
    }

    /**
     * Obtenir les créneaux pour une date spécifique
     */
    public function forDate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today'
        ]);

        $timeSlots = TimeSlot::forDate($request->date)
                            ->orderBy('start_time')
                            ->get()
                            ->map(function ($slot) {
                                return [
                                    'id' => $slot->id,
                                    'start_time' => $slot->start_time->format('H:i'),
                                    'end_time' => $slot->end_time->format('H:i'),
                                    'formatted_time' => $slot->formatted_time,
                                    'max_capacity' => $slot->max_capacity,
                                    'current_bookings' => $slot->current_bookings,
                                    'remaining_capacity' => $slot->remaining_capacity,
                                    'is_available' => $slot->isAvailable(),
                                ];
                            });

        return response()->json($timeSlots);
    }

    /**
     * Générer les créneaux pour une période
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $created = 0;

        // Créneaux par défaut
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
                $existing = TimeSlot::where('date', $date->format('Y-m-d'))
                                  ->where('start_time', $slot[0])
                                  ->where('end_time', $slot[1])
                                  ->exists();

                if (!$existing) {
                    TimeSlot::create([
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slot[0],
                        'end_time' => $slot[1],
                        'max_capacity' => 10,
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
}