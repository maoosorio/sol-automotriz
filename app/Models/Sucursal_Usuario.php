<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal_Usuario extends Model
{
    use HasFactory;

    protected $table = "sucursales_usuarios";
    protected $fillable = [
        'sucursal_id', 'usuario_id', 'valor'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

}
