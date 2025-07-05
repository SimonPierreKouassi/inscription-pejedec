<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder pour créer les utilisateurs par défaut
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur par défaut
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@rdvmanager.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Créer un manager par défaut
        User::create([
            'name' => 'Manager',
            'email' => 'manager@rdvmanager.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Utilisateurs par défaut créés avec succès !');
    }
}