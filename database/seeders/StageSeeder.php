<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Stage;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stage::create([
            'name'  => 'Evaluacion de requerimientos'
        ]);
        Stage::create([
            'name'  => 'Acondicionamiento de materiales'
        ]);
        Stage::create([
            'name'  => 'Trabajo de ensamblaje'
        ]);
        Stage::create([
            'name'  => 'Trabajo de soldadura'
        ]);
        Stage::create([
            'name'  => 'Prueba hidrostatica/hermeticidad'
        ]);
        Stage::create([
            'name'  => 'Trabajo de acabados/limpieza'
        ]);
    }
}
