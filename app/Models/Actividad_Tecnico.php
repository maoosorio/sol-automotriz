<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actividad_Tecnico extends Model
{
    use HasFactory;
    protected $table = "actividades_tecnicos";
    protected $fillable = [
        'actividad_id', 'horario_id', 'vehiculo_id', 'actividad',
    ];

    static public function lista($id)
    {
        $consulta = DB::select("SELECT a.id, a.vehiculo_id, a.horario_id
                                    , a.actividad_id, a.actividad
                                    , h.hora AS hora
                                    , v.vehiculo AS vehiculo
                                FROM actividades_tecnicos a
                                JOIN horarios h ON h.id = a.horario_id
                                JOIN vehiculos v ON v.id = a.vehiculo_id
                                WHERE actividad_id = '$id' ORDER BY h.id ASC");
        return $consulta;
    }

    static public function listaVehiculo($fecha_inicio, $fecha_final, $vehiculo_id)
    {
        $consulta = DB::select("SELECT
                                    a.id,
                                    a.vehiculo_id,
                                    a.horario_id,
                                    a.actividad_id,
                                    a.actividad,
                                    h.hora AS hora,
                                    v.vehiculo AS vehiculo,
                                    t.nombre AS nombre,
                                    c.fecha AS fecha
                                FROM
                                    actividades_tecnicos a
                                    JOIN horarios h ON h.id = a.horario_id
                                    JOIN vehiculos v ON v.id = a.vehiculo_id
                                    JOIN actividades c ON c.id = a.actividad_id
                                    JOIN tecnicos t ON t.id = c.tecnico_id
                                WHERE
                                    c.fecha BETWEEN '$fecha_final' AND '$fecha_inicio' AND v.id = '$vehiculo_id'
                                ORDER BY
                                c.fecha ASC , h.id ASC");
        return $consulta;
    }

    static public function listaTecnico($fecha_inicio, $fecha_final, $tecnico_id)
    {
        $consulta = DB::select("SELECT
                                    a.id,
                                    a.vehiculo_id,
                                    a.horario_id,
                                    a.actividad_id,
                                    a.actividad,
                                    h.hora AS hora,
                                    v.vehiculo AS vehiculo,
                                    t.nombre AS nombre,
                                    c.fecha AS fecha
                                FROM
                                    actividades_tecnicos a
                                    JOIN horarios h ON h.id = a.horario_id
                                    JOIN vehiculos v ON v.id = a.vehiculo_id
                                    JOIN actividades c ON c.id = a.actividad_id
                                    JOIN tecnicos t ON t.id = c.tecnico_id
                                WHERE
                                    c.fecha BETWEEN '$fecha_final' AND '$fecha_inicio' AND t.id = '$tecnico_id'
                                ORDER BY
                                c.fecha ASC , h.id ASC");
        return $consulta;
    }

}
