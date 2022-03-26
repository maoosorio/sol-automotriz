<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo_Tecnico extends Model
{
    use HasFactory;
    protected $table = "prestamos_tecnicos";
    protected $fillable = [
        'prestamo_id', 'monto', 'fecha', 'estado'
    ];
}
