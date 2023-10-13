<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = Role::create(['name' => 'Administrador']);

        $rol->permissions()->attach([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,38,39,40,41,42,43]);
        
        $rol = Role::create(['name' => 'Asistente']);

        $rol->permissions()->attach([1,2,3,5,6,7,9,10,11,13,14,15,17,18,19,21,22,23,24,26,27,28,29,30,31,32,33,34,35,36,38,39,40,41,42,43]);

        $rol = Role::create(['name' => 'Jefe de Producción']);

        $rol->permissions()->attach([30,31,32,33]);

        $rol = Role::create(['name' => 'Cliente']);

        $rol->syncPermissions(['Ver Menú Clientes']);
    }
}
