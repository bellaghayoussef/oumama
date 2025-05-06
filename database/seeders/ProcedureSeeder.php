<?php

namespace Database\Seeders;

use App\Models\Procedure;
use Illuminate\Database\Seeder;

class ProcedureSeeder extends Seeder
{
    public function run(): void
    {
        $procedures = [
            [
                'name' => 'Demande de Visa',
                'description' => 'Procédure pour la demande de visa de séjour'
            ],
            [
                'name' => 'Renouvellement de Carte',
                'description' => 'Procédure pour le renouvellement de carte de séjour'
            ],
            [
                'name' => 'Demande de Nationalité',
                'description' => 'Procédure pour la demande de nationalité'
            ],
            [
                'name' => 'Regroupement Familial',
                'description' => 'Procédure pour le regroupement familial'
            ],
            [
                'name' => 'Demande d\'Asile',
                'description' => 'Procédure pour la demande d\'asile'
            ]
        ];

        foreach ($procedures as $procedure) {
            Procedure::create($procedure);
        }
    }
} 