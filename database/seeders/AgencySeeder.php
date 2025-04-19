<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use Illuminate\Support\Facades\Hash;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = [
            [
                'name' => 'Agence Centrale',
                'email' => 'agence.centrale@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0123456789',
                'address' => '123 Rue Principale, Ville',
                'is_active' => true
            ],
            [
                'name' => 'Agence Régionale Nord',
                'email' => 'agence.nord@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0234567890',
                'address' => '456 Avenue du Nord, Ville Nord',
                'is_active' => true
            ],
            [
                'name' => 'Agence Régionale Sud',
                'email' => 'agence.sud@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0345678901',
                'address' => '789 Boulevard du Sud, Ville Sud',
                'is_active' => true
            ],
            [
                'name' => 'Agence Régionale Est',
                'email' => 'agence.est@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0456789012',
                'address' => '101 Rue de l\'Est, Ville Est',
                'is_active' => true
            ],
            [
                'name' => 'Agence Régionale Ouest',
                'email' => 'agence.ouest@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0567890123',
                'address' => '202 Avenue de l\'Ouest, Ville Ouest',
                'is_active' => true
            ]
        ];

        foreach ($agencies as $agency) {
            Agency::create($agency);
        }
    }
} 