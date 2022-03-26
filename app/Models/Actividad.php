<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actividad extends Model
{
    use HasFactory;

    protected $table = "actividades";
    protected $fillable = [
        'fecha', 'tecnico_id',
    ];

    static public function sucursal($id, $ayer, $hoy)
    {
        $consulta = DB::select("SELECT a.id
                                    , a.tecnico_id
                                    , a.fecha
                                    , t.nombre AS nombre
                                    , s.nombre AS sucursal
                                FROM actividades a
                                JOIN tecnicos t ON t.id = a.tecnico_id
                                JOIN sucursales s ON s.id = t.sucursal_id
                                WHERE a.fecha BETWEEN  '$ayer' AND '$hoy' AND s.id = '$id' ORDER BY a.fecha ASC");
        return $consulta;
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }
}
