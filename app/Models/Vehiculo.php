<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehiculo', 'placa', 'sucursal_id', 'estado', 'referencia', 'asesoria_tecnica'
    ];

    static public function listaEtapa()
    {
        $consulta = DB::select("SELECT max(e.etapa) as etapa,  max(e.proceso_padre) as pro, u.name as nombre, v.vehiculo, p.proceso, v.asesoria_tecnica, e.created_at as fecha
        FROM etapas e
        JOIN procesos p ON e.proceso_id = p.id
        JOIN vehiculos v ON p.vehiculo_id = v.id
        JOIN users u ON e.usuario_id = u.id
        WHERE v.asesoria_tecnica = 1
        GROUP BY v.vehiculo ORDER BY pro, etapa ASC");
        return $consulta;
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function traslado()
    {
        return $this->hasMany(Traslado::class);
    }

    public function alta()
    {
        return $this->hasMany(Alta::class);
    }

    public function proceso()
    {
        return $this->hasMany(Proceso::class);
    }
}
