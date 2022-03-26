<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SeederTablaSucursales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursales = [
            'Todas',
            'Sala de Espera',
            'Alcalde',
        ];

        foreach($sucursales as $sucursal) {
            Sucursal::create(['nombre'=>$sucursal]);
        }
    }
}
