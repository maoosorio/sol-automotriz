<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Traslado extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_origen', 'sucursal_destino', 'vehiculo_id', 'usuario_id', 'observaciones', 'link', 'estado'
    ];

    static public function listaTraslados()
    {
        $consulta = DB::select("SELECT
                                t.id, v.vehiculo as vehiculo ,so.nombre as origen, sd.nombre as destino,t.estado
                            FROM
                                traslados t
                                LEFT JOIN sucursales so ON t.sucursal_origen = so.id
                                LEFT JOIN sucursales sd ON t.sucursal_destino = sd.id
                                LEFT JOIN vehiculos v ON t.vehiculo_id = v.id");
        return $consulta;
    }

    static public function listaTrasladosN($id)
    {
        $consulta = DB::select("SELECT
                                t.id, v.vehiculo as vehiculo ,so.nombre as origen, sd.nombre as destino,t.estado
                            FROM
                                traslados t
                                LEFT JOIN sucursales so ON t.sucursal_origen = so.id
                                LEFT JOIN sucursales sd ON t.sucursal_destino = sd.id
                                LEFT JOIN vehiculos v ON t.vehiculo_id = v.id
                                WHERE sucursal_origen = $id or sucursal_destino = $id");
        return $consulta;
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
