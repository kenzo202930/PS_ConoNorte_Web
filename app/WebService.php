<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WebService extends Model
{
    public static function ListarEspecialistasDia($DiaSemana)
    {
        try {
            $resultado = DB::select(DB::raw("select e.id,e.Especialidad,m.Nombre,ct.Nro_Citas,c.Especialista_Id,m.id IdMedico
                    from cita_especialistas c
                    join citas ct on ct.id = c.Cita_Id
                    join especialistas e on e.id = c.Especialista_Id
                    join medicos m on m.Especialista_Id = e.id
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

    public static function TotalCitasEspecilidadDia($EspecialidadId)
    {
        $FechaHoy = Carbon::today()->toDateString();
        $res = CitaUsuario::where('Especialidad_Id',$EspecialidadId)->where('Fecha',$FechaHoy)->count();
        return $res;
    }

    public static function ValidarAsistenciaEspecialista($MedicoID){
        $FechaHoy = Carbon::today()->toDateString();
        $resultado = TurnoEspecialista::where('MedicoId',$MedicoID)->where('Fecha',$FechaHoy)->count();
        return $resultado;
    }
}
