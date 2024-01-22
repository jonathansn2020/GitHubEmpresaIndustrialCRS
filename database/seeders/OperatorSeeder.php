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
            'name'      => 'Operador 1',
            'document'  => '44395959',
            'phone'     => '984858583',
            'email'     => 'operario1@gmail.com',
            'position'  => 'Operario 1'       
        ]);
        Operator::create([
            'name'      => 'Operador 2',
            'document'  => '40395913',
            'phone'     => '994854501',
            'email'     => 'operario2@gmail.com',
            'position'  => 'Operario 2'       
        ]);
        Operator::create([
            'name'      => 'Operador 3',
            'document'  => '44300911',
            'phone'     => '92851500',
            'email'     => 'operario3@gmail.com',
            'position'  => 'Operario 3'       
        ]);
        Operator::create([
            'name'      => 'Operador 4',
            'document'  => '41300911',
            'phone'     => '990054504',
            'email'     => 'operario4@gmail.com',
            'position'  => 'Operario 4'       
        ]);
        Operator::create([
            'name'      => 'Operador 5',
            'document'  => '40310219',
            'phone'     => '98841511',
            'email'     => 'operario5@gmail.com',
            'position'  => 'Operario 5'       
        ]);
        Operator::create([
            'name'      => 'Operador 6',
            'document'  => '41312200',
            'phone'     => '93340914',
            'email'     => 'operario6@gmail.com',
            'position'  => 'Operario 6'       
        ]);
        Operator::create([
            'name'      => 'Operador 7',
            'document'  => '48460973',
            'phone'     => '98743591',
            'email'     => 'operario7@gmail.com',
            'position'  => 'Operario 7'       
        ]);
        Operator::create([
            'name'      => 'Operador 8',
            'document'  => '42313914',
            'phone'     => '98941501',
            'email'     => 'operario8@gmail.com',
            'position'  => 'Operario 8'       
        ]);
    }
}
