<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminSeeder::class,
            AgencySeeder::class,
            ProcedureSeeder::class,
            EtapSeeder::class,
            TaskSeeder::class,
            FormulerSeeder::class,
            VariableSeeder::class,
           // RepenceSeeder::class
        ]);
    }
}
