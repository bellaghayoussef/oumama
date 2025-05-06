<?php

namespace Database\Seeders;

use App\Models\Formuler;
use App\Models\Task;
use Illuminate\Database\Seeder;

class FormulerSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            $formules = [
                [
                    'name' => 'Formulaire de Vérification',
                    'description' => 'Formulaire pour vérifier les documents',
                    'task_id' => $task->id,
                   
                ],
                [
                    'name' => 'Formulaire d\'Analyse',
                    'description' => 'Formulaire pour analyser la demande',
                    'task_id' => $task->id,
                    
                ],
                [
                    'name' => 'Formulaire de Décision',
                    'description' => 'Formulaire pour prendre une décision',
                    'task_id' => $task->id,
                   
                ]
            ];

            foreach ($formules as $formule) {
                Formuler::create($formule);
            }
        }
    }
} 