<?php

namespace App\Http\Controllers\Api;

use App\Cita;
use App\CitaUsuario;
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


}
