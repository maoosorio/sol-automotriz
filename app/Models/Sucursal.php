<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = "sucursales";

    protected $fillable = [
        'nombre','direccion', 'telefono', 'gerente'
    ];

    public function user()
    {
        return $this->hasMany(Sucursal_Usuario::class);
    }

    public function tecnico()
    {
        return $this->hasMany(Tecnico::class);
    }

    public function vehiculo()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function traslado()
    {
        return $this->hasMany(Traslado::class);
    }

    public function alta()
    {
        return $this->hasMany(Alta::class);
    }

    public function prestamo()
    {
        return $this->hasMany(Prestamo::class);
    }

}
