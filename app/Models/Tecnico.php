<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tecnico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre','tipo', 'sucursal_id'
    ];

    static public function listaTecnico()
    {
        $consulta = DB::select("SELECT t.* FROM tecnicos t WHERE NOT EXISTS ( SELECT p.id, p.estado FROM prestamos p WHERE t.id = p.tecnico_id and p.estado = 1)");
        return $consulta;
    }

    public function actividad()
    {
        return $this->hasMany(Actividad::class);
    }

    public function prestamo()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
