<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioLog extends Model
{
    use HasFactory;

    protected $table = "usuarios_logs";
    protected $fillable = [
        'usuario_id', 'accion', 'tabla'
    ];
}
