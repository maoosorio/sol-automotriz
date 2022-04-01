<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal_Usuario extends Model
{
    use HasFactory;

    protected $table = "sucursal_user";
    protected $fillable = [
        'sucursal_id', 'user_id', 'valor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

}
