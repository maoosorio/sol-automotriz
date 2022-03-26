<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alta extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehiculo_id', 'sucursal_id', 'fecha', 'usuario_id'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
