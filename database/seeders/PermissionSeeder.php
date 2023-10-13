<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Crear Usuarios'
        ]);
        Permission::create([
            'name' => 'Listar Usuarios'
        ]);
        Permission::create([
            'name' => 'Actualizar Usuarios'
        ]);
        Permission::create([
            'name' => 'Eliminar Usuarios'
        ]);
        Permission::create([
            'name' => 'Crear Roles'
        ]);
        Permission::create([
            'name' => 'Listar Roles'
        ]);
        Permission::create([
            'name' => 'Actualizar Roles'
        ]);
        Permission::create([
            'name' => 'Eliminar Roles'
        ]);
        Permission::create([
            'name' => 'Crear Etapas'
        ]);
        Permission::create([
            'name' => 'Listar Etapas'
        ]);
        Permission::create([
            'name' => 'Actualizar Etapas'
        ]);
        Permission::create([
            'name' => 'Eliminar Etapas'
        ]);
        Permission::create([
            'name' => 'Crear Actividades'
        ]);
        Permission::create([
            'name' => 'Listar Actividades'
        ]);
        Permission::create([
            'name' => 'Actualizar Actividades'
        ]);
        Permission::create([
            'name' => 'Eliminar Actividades'
        ]);
        Permission::create([
            'name' => 'Crear Operarios'
        ]);
        Permission::create([
            'name' => 'Listar Operarios'
        ]);
        Permission::create([
            'name' => 'Actualizar Operarios'
        ]);
        Permission::create([
            'name' => 'Eliminar Operarios'
        ]);
        Permission::create([
            'name' => 'Crear Ordenes'
        ]);
        Permission::create([
            'name' => 'Listar Ordenes'
        ]);
        Permission::create([
            'name' => 'Ver Ordenes'
        ]);
        Permission::create([
            'name' => 'Actualizar Ordenes'
        ]);
        Permission::create([
            'name' => 'Eliminar Ordenes'
        ]);
        Permission::create([
            'name' => 'Planificar Proyectos'
        ]);
        Permission::create([
            'name' => 'Listar Proyectos'
        ]);
        Permission::create([
            'name' => 'Ver Proyectos'
        ]);
        Permission::create([
            'name' => 'Actualizar Proyectos'
        ]);
        Permission::create([
            'name' => 'Realizar Control de Radiadores'
        ]);
        Permission::create([
            'name' => 'Listar Producción de Radiadores'
        ]);
        Permission::create([
            'name' => 'Ver Gráfico de Reprocesos de Radiadores'
        ]);
        Permission::create([
            'name' => 'Ver Detalle de Reprocesos de Radiadores'
        ]);
        Permission::create([
            'name' => 'Ver Gráfico Ordenes Retrasadas'
        ]);
        Permission::create([
            'name' => 'Ver Gráfico Ordenes Entregadas a Tiempo'
        ]);
        Permission::create([
            'name' => 'Ver Dashboard'
        ]);
        Permission::create([
            'name' => 'Ver Menú Clientes'
        ]);
        Permission::create([
            'name' => 'Listar Reportes Gráficos'
        ]);
        Permission::create([
            'name' => 'Cambiar Password'
        ]);
        Permission::create([
            'name' => 'Listar Reportes PDF'
        ]);
        Permission::create([
            'name' => 'Ver reporte pdf de ordenes entregadas a tiempo'
        ]);
        Permission::create([
            'name' => 'Ver reporte pdf de actividades con reproceso'
        ]);
        Permission::create([
            'name' => 'Ver reporte pdf de operario con reproceso'
        ]);
    }
}
