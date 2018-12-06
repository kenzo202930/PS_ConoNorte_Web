<?php

namespace App\Http\Controllers\Api;

use App\Cita;
use App\CitaUsuario;
use App\TurnoEspecialista;
use App\WebService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WebServiceController extends Controller
{
    public function fncValidarLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            return response()->json($user);
        }
    }

    public function fncListarEspecialistasDia()
    {
        $DiaActual = Carbon::now();
        $NumeroDia = $DiaActual->dayOfWeekIso;
        $lista = WebService::ListarEspecialistasDia($NumeroDia);
        return response()->json(['data' => $lista]);
    }

    public function fncRegistrarCitaUsuario(Request $request)
    {
        $DiaEntrante = Carbon::today();
        $NumeroDia = $DiaEntrante->dayOfWeekIso;
        try {
            $CantidadCitasRegistradas = CitaUsuario::where('Fecha', $DiaEntrante)->count();
            $TotalNroCitas = Cita::where('DiaSemana', $NumeroDia)->first()->Nro_Citas;
            if ($CantidadCitasRegistradas < $TotalNroCitas) {
                $status = WebService::RegistrarCitaUsuario($request);
            } else {
                $status = false;
            }
        } catch (QueryException $ex) {
            $status = $ex->errorInfo;
        }
        return response()->json(['data' => $status]);
    }

    public function TotalCitasRestantes(Request $request)
    {
        $EspecialidadId = $request->input('Especialista_Id');


        $TotalCitasxEspecilista = WebService::TotalCitasEspecilidadDia($EspecialidadId);

        return response()->json(['Total' => $TotalCitasxEspecilista]);
    }

    public function ValidarMedicoAsistencia(Request $request)
    {
        $MedicoID = $request->input('MedicoId');
        $Validar = WebService::ValidarAsistenciaEspecialista($MedicoID);
        return response()->json(['Validar' => $Validar]);
    }

    public function RegistrarMedicoAsistencia(Request $request)
    {
        $MedicoId = $request->input('MedicoId');
        $resultado = WebService::RegistrarMedicoAsistencia($request);
        return response()->json(['data' => $resultado]);
    }


}
