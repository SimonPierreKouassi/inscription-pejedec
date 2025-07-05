<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder pour générer les créneaux horaires
 */
class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::parse('2024-07-07');
        $endDate = $startDate->copy()->addMonths(3);

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
                TimeSlot::create([
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $slot[0],
                    'end_time' => $slot[1],
                    'max_capacity' => 10,
                    'current_bookings' => 0,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Créneaux horaires générés avec succès !');
    }
}