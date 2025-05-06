<?php

namespace Database\Seeders;

use App\Models\Repence;
use App\Models\Variable;
use Illuminate\Database\Seeder;

class RepenceSeeder extends Seeder
{
    public function run(): void
    {
        $variables = Variable::all();

        foreach ($variables as $variable) {
            $reponses = [
                [
                    'value' => $variable->type === 'select' ? 'En cours' : 'Réponse standard',
                    'variable_id' => $variable->id,
                    'user_id' => 1 // Assuming user ID 1 exists
                ],
                [
                    'value' => $variable->type === 'select' ? 'Terminé' : 'Réponse complémentaire',
                    'variable_id' => $variable->id,
                    'user_id' => 1
                ]
            ];

            foreach ($reponses as $reponse) {
                Repence::create($reponse);
            }
        }
    }
} 