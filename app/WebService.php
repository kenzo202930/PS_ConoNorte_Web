<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WebService extends Model
{
    public static function ListarEspecialistasDia($DiaSemana)
    {
        try {
            $resultado = DB::select(DB::raw("select e.id,e.Especialidad
                    from cita_especialistas c
                    join citas ct on ct.id = c.Cita_Id
                    join especialistas e on e.id = c.Especialista_Id
                    where ct.DiaSemana = '$DiaSemana'"));
        } catch (QueryException $ex) {
            $resultado = $ex->errorInfo;
        }
        return $resultado;
    }

    public static function RegistrarCitaUsuario(Request $request)
    {
        try {
            $resultado = CitaUsuario::create($request->all());
            $respuesta = true;
        } catch (QueryException $ex) {
            $resultado = $ex->errorInfo;
            $respuesta = false;
        }
        return $respuesta;
    }
}
