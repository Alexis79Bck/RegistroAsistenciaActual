<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $connection ="ra";

    protected $fillable = [
        'nombre_apellido', 'departamento', 'cedula', 'fecha', 'hora_entrada','hora_salida',
    ];
}
