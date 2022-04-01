<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehiculo', 'placa', 'sucursal_id', 'estado', 'referencia'
    ];

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
}
