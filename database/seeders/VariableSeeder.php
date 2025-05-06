<?php

namespace Database\Seeders;

use App\Models\Variable;
use App\Models\Formuler;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    public function run(): void
    {
        $formules = Formuler::all();

        foreach ($formules as $formule) {
            $variables = [
                [
                    'name' => 'Statut',
                    'type' => 'file',
                  
                    'formuler_id' => $formule->id,
                  
                ],
                [
                    'name' => 'Commentaire',
                    'type' => 'string',
                  
                    'formuler_id' => $formule->id,
                  
                ],
                [
                    'name' => 'Date de Vérification',
                    'type' => 'string',
                
                    'formuler_id' => $formule->id,
                    
                ]
            ];

            foreach ($variables as $variable) {
                Variable::create($variable);
            }
        }
    }
} 