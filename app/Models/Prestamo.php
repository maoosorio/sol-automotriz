<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tecnico_id', 'monto', 'pagos', 'estado', 'tipo'
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
