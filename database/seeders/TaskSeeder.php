<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Etap;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $etaps = Etap::all();

        foreach ($etaps as $etap) {
            $tasks = [
                [
                    'name' => 'Vérification des Documents',
                    'description' => 'Vérifier la validité et l\'authenticité des documents soumis',
                    'etap_id' => $etap->id,
                    'intervenant' => 'agence',
                    'delait' => 3
                ],
                [
                    'name' => 'Analyse de la Demande',
                    'description' => 'Analyser la demande et les documents fournis',
                    'etap_id' => $etap->id,
                    'intervenant' => 'admin',
                    'delait' => 5
                ],
                [
                    'name' => 'Préparation du Dossier',
                    'description' => 'Préparer le dossier pour la suite de la procédure',
                    'etap_id' => $etap->id,
                    'intervenant' => 'agence',
                    'delait' => 2
                ]
            ];

            foreach ($tasks as $task) {
                Task::create($task);
            }
        }
    }
} 