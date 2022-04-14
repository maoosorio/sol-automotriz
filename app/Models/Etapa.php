<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'proceso_id', 'etapa', 'valor', 'proceso_padre', 'usuario_id'
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
}
