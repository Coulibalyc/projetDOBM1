<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Boursier;
use App\Models\boursiers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Import de la Factory Faker
use Faker\Factory as Faker;

class BoursiersUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crée une instance unique de Faker
        $faker = Faker::create();

        boursiers::all()->each(function ($boursier) use ($faker) {
            // Génère un email unique avec Faker
            $email = $faker->unique()->safeEmail;

            User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => "{$boursier->nom} {$boursier->prenom}",
                    'password' => Hash::make('MotDePasseParDefaut'),
                    'role'     => 'boursier',
                ]
            );
        });
    }
}
