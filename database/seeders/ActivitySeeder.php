<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::create([
            'name' => 'Tomar medidas del modelo original',
            'stage_id' => 1
        ]);
        Activity::create([
            'name' => 'Analizar y evaluar medidas de radiador',
            'stage_id' => 1
        ]);
        Activity::create([
            'name' => 'Realizar diseño de radiador',
            'stage_id' => 1
        ]);
        Activity::create([
            'name' => 'Cortar laminas a medida',
            'stage_id' => 2
        ]);
        Activity::create([
            'name' => 'Troquelar flejes a medida',
            'stage_id' => 2
        ]);
        Activity::create([
            'name' => 'Cortar tubos a medida',
            'stage_id' => 2
        ]);
        Activity::create([
            'name' => 'Habilitar tuberias',
            'stage_id' => 2
        ]);
        Activity::create([
            'name' => 'Ensamblar panel de radiador con aletas y tubos',
            'stage_id' => 3
        ]);
        Activity::create([
            'name' => 'Realizar trabajos de soldadura',
            'stage_id' => 4
        ]);
        Activity::create([
            'name' => 'Preparar ambiente de pruebas',
            'stage_id' => 5
        ]);
        Activity::create([
            'name' => 'Realizar prueba de hermeticidad y/o hidrostatica',
            'stage_id' => 5
        ]);
        Activity::create([
            'name' => 'Realizar limpieza y acabados finales',
            'stage_id' => 6
        ]);
    }
}
