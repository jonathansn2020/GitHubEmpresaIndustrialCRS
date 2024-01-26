<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Operator;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operator::create([
            'name'      => 'Gino Octavio Peña Lucero',
            'document'  => '41805280',
            'phone'     => '984302540',
            'email'     => 'gino_peña@gmail.com',
            'position'  => 'Jefatura Comercial'       
        ]);
        Operator::create([
            'name'      => 'Heraclides Prado Espinoza',
            'document'  => '08545223',
            'phone'     => '994854501',
            'email'     => 'hprado_esp@gmail.com',
            'position'  => 'Operario Producción'       
        ]);
        Operator::create([
            'name'      => 'Carlos Ananias Zarate Martinez',
            'document'  => '47455774',
            'phone'     => '92851500',
            'email'     => 'carlos_azm@gmail.com',
            'position'  => 'Operario Soldador'       
        ]);
        Operator::create([
            'name'      => 'Alex Cruz Calderon',
            'document'  => '06898605',
            'phone'     => '990054504',
            'email'     => 'alex_cruzc@gmail.com',
            'position'  => 'Asistente de Producción'       
        ]);
        Operator::create([
            'name'      => 'Daniel Inga Mas',
            'document'  => '10449870',
            'phone'     => '98841511',
            'email'     => 'daniel_ingm@gmail.com',
            'position'  => 'Asistente de Producción'       
        ]);
        
    }
}
