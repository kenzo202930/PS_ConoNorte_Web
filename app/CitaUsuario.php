<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitaUsuario extends Model
{
    protected $fillable = [
        'Fecha','Nombre','Apellido','DNI','Especialidad_Id'
    ];
}
