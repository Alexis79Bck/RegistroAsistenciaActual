<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrenominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function incidenciasIndex()
    {
        $maxFijadoFechaInicio = new Carbon('yesterday');
        $minFijadoFechaInicio = new Carbon('yesterday -45 days');
        $empleados = [];
       // dd($maxFijadoFechaInicio, $minFijadoFechaInicio);
       return view('prenomina.incidencias.index', compact('maxFijadoFechaInicio','minFijadoFechaInicio','empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mostrarIncidencias(Request $request)
    {
        $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','SubDepartamento_id')->where('Departamento_id','=', $request->departamento)->where('inactivo','=',false)->get();
        $departamento = DB::connection('merulink')->table('Departamentos')->where('codigo','=',$request->departamento)->first();

        $fechaInicio = new Carbon($request->fechaInicio);
        $fechaFin = new Carbon($request->fechaFin);

        $diferenciaDias = $fechaFin->diffInDays($fechaInicio) + 1;

        for ($i=0; $i < $diferenciaDias ; $i++) {

            $tmp = new Carbon($request->fechaInicio . ' +' . $i . 'days');
            $listaFechas[$i] = $tmp->toDateString();

            if ($tmp->locale('es')->day >= 1 && $tmp->locale('es')->day <= 15) {
                $quincena[$i] = 1;
            }else{
                $quincena[$i] = 2;
            }

            for ($j=0; $j < count($empleados) ; $j++) {
                $listaCedulaEmpleados[$j] = $empleados[$j]->cedula;
                $empleadoHorario[$i][$j] = DB::connection('merulink')->table('empleado_horarios')
                                        ->where('cedula_empleado','=', $empleados[$j]->cedula )
                                        ->where('mes','=',$tmp->locale('es')->monthName)
                                        ->where('quincena','=',$quincena[$i])
                                        ->first();

                if ($empleadoHorario[$i][$j] != null) {


                    // $resultadoEmpleadoHorario[$i][$j]['cedula'] = $empleados[$j]->cedula;
                    // $resultadoEmpleadoHorario[$i][$j]['fecha']=$tmp->toDateString();
                    // $resultadoEmpleadoHorario[$i][$j]['mes']=$tmp->locale('es')->month;
                    // $resultadoEmpleadoHorario[$i][$j]['quincena']=$quincena[$i];

                    //  $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['cedula'] = $empleados[$j]->cedula;
                    // $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['fecha']=$tmp->toDateString();
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['mes']=$tmp->locale('es')->month;
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['quincena']=$quincena[$i];
                    if ($quincena[$i] == 1) {

                        switch ($tmp->locale('es')->day) {
                            case 1:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D1;
                                break;

                            case 2:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                break;

                            case 3:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                break;

                            case 4:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                break;

                            case 5:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                break;

                            case 6:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                break;

                            case 7:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                break;

                            case 8:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                break;

                            case 9:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                break;

                            case 10:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                break;

                            case 11:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                break;

                            case 12:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                break;

                            case 13:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                break;

                            case 14:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                break;

                            case 15:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                break;
                        }

                    }else{
                        switch ($tmp->locale('es')->day) {
                            case 16:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D1;
                                break;

                            case 17:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                break;

                            case 18:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                break;

                            case 19:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                break;

                            case 20:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                break;

                            case 21:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                break;

                            case 22:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                break;

                            case 23:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                break;

                            case 24:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                break;

                            case 25:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                break;

                            case 26:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                break;

                            case 27:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                break;

                            case 28:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                break;

                            case 29:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                break;

                            case 30:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                break;

                            case 31:
                                $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D16;
                                break;
                        }
                    }


                    if ($resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] == 'Libre') {
                        $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraEntrada'] = 'Libre';
                        $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraSalida'] = 'Libre';

                    }else{
                        $turno = DB::connection('merulink')->table('Horarios')
                                        ->where('codigo','=', $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] )
                                        ->first();
                        $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraEntrada'] = $turno->hora_entrada;
                        $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraSalida'] = $turno->hora_salida;
                    }

                }else{
                    // $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['cedula'] = null;
                    // $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['fecha']=$tmp->toDateString();
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['mes']=$tmp->locale('es')->month;
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['quincena']=$quincena;
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =null;
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraEntrada'] = null;
                    $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['TurnoHoraSalida'] = null;
                }

                $Asistencia[$tmp->toDateString()][$empleados[$j]->cedula]['Registro'] = DB::connection('ra')->table('asistencia')
                                                                                                        ->where('cedula','=' ,$empleados[$j]->cedula)
                                                                                                        ->where('fecha','=', $tmp->toDateString())
                                                                                                        ->first();

            }
        }

       dd($fechaInicio->toDateString(), $fechaFin->toDateString(), $diferenciaDias, $listaFechas, $listaCedulaEmpleados, $resultadoEmpleadoHorario, $Asistencia );

       return view('livewire.prenomina.incidencias.mostrar-incidencias', compact('empleados','departamento'));
    }

}
