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
            '1 ver-ajuste',

            '1.1 ver-sucursal',
            '1.1.1 crear-sucursal',
            '1.1.2 editar-sucursal',
            '1.1.3 borrar-sucursal',

            '1.2 ver-usuario',
            '1.2.1 crear-usuario',
            '1.2.2 editar-usuario',
            '1.2.3 asginar-sucursal',
            '1.2.4 borrar-usuario',

            '1.3 ver-rol',
            '1.3.1 crear-rol',
            '1.3.2 editar-rol',
            '1.3.3 borrar-rol',

            '2 ver-personal',

            '2.1 ver-administrativo',
            '2.1.1 crear-administrativo',
            '2.1.2 editar-administrativo',
            '2.1.3 borrar-administrativo',

            '2.2 ver-tecnico',
            '2.2.1 crear-tecnico',
            '2.2.2 editar-tecnico',
            '2.2.3 borrar-tecnico',

            '3 ver-vehiculo',
            '3.1 crear-vehiculo',
            '3.2 editar-vehiculo',
            '3.3 borrar-vehiculo',

            '4 ver-traslado',
            '4.1 crear-traslado',
            '4.2 editar-traslado',
            '4.3 aprobar-traslado',
            '4.4 borrar-traslado',

            '5 ver-actividad',
            '5.1 crear-actividad',
            '5.2 ver-asignacion',
            '5.3 borrar-actividad',

            // '5.4 ver-asignacion',
            '5.2.1 crear-asignacion',
            // '5.2.2 editar-asignacion',
            '5.2.3 borrar-asignacion',
            '5.2.4 agregar-valorme',
            '5.2.5 agregar-valormo',
            '5.2.6 aprobar-valorme',
            '5.2.7 aprobar-valormo',

            '6 ver-prestamo',
            '6.1 crear-prestamo',
            '6.2 ver-pagos',
            '6.3 borrar-prestamo',

            '7 ver-alta',
            '7.1 crear-alta',
            // '7.2 editar-alta',
            '7.2 borrar-alta',

            '8 ver-reporte',

            '8.1 ver-rv',
            '8.1.1 ver-rvs',

            '8.2 ver-rt',
            '8.2.1 ver-rts',

            '8.3 ver-ra',
            '8.3.1 ver-ras',

            '8.4 ver-rp',
            '8.4.1 ver-rps',

            '8.5 ver-rm',
            '8.5.1 ver-rms',

            '3.4 agregar-pat',
            '3.5 borrar-pat',
            '3.6 ver-pat',
            '3.6.1 agregar-proceso',
            '3.6.2 borrar-proceso',
            '3.6.1.1 agregar-etapa',
            '3.6.1.2 borrar-etapa',

            '9 ver-pat',
            '8.6 ver-rpat',

            '6.3 agregar-pago',

        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }
    }
}
