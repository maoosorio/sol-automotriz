<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',

            'ver-tecnico',
            'crear-tecnico',
            'editar-tecnico',
            'borrar-tecnico',

            'ver-vehiculo',
            'crear-vehiculo',
            'editar-vehiculo',
            'borrar-vehiculo',

            'ver-reporte',
            'crear-reporte',
            'editar-reporte',
            'borrar-reporte',

            'ver-actividad',
            'crear-actividad',
            'editar-actividad',
            'borrar-actividad',

            'ver-asignacion',
            'crear-asignacion',
            'editar-asignacion',
            'borrar-asignacion',
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }
    }
}
