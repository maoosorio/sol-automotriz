<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre','tipo', 'sucursal_id'
    ];

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
