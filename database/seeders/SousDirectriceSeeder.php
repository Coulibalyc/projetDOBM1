<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SousDirectriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Sous-Directrice',
            'email'    => 'sousdirectrice@example.com',
            'password' => Hash::make('Secret123!'),
            'role'     => 'sous_directrice',
        ]);
    }
}
