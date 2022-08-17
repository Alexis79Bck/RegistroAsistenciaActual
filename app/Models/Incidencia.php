<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $connection = 'ra';
    protected $fillable = ['fecha', 'cedula_empleado', 'mensaje', 'observacion'];
    public $timestamps = false;
}
