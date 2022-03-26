<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_origen', 'sucursal_destino', 'vehiculo_id', 'usuario_id', 'observaciones', 'link', 'estado'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
