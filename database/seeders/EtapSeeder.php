<?php

namespace Database\Seeders;

use App\Models\Etap;
use App\Models\Procedure;
use Illuminate\Database\Seeder;

class EtapSeeder extends Seeder
{
    public function run(): void
    {
        $procedures = Procedure::all();

        foreach ($procedures as $procedure) {
            $etaps = [
                [
                    'name' => 'Soumission des Documents',
                    'description' => 'Première étape : soumission des documents requis',
                    'procedure_id' => $procedure->id,
                    'delait' => 7
                ],
                [
                    'name' => 'Vérification des Documents',
                    'description' => 'Deuxième étape : vérification de la validité des documents',
                    'procedure_id' => $procedure->id,
                    'delait' => 14
                ],
                [
                    'name' => 'Entretien',
                    'description' => 'Troisième étape : entretien avec le demandeur',
                    'procedure_id' => $procedure->id,
                    'delait' => 21
                ],
                [
                    'name' => 'Décision Finale',
                    'description' => 'Dernière étape : prise de décision finale',
                    'procedure_id' => $procedure->id,
                    'delait' => 30
                ]
            ];

            foreach ($etaps as $etap) {
                Etap::create($etap);
            }
        }
    }
} 