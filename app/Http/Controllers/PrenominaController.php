<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class PrenominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function incidenciasIndex()
    {

        // $dataSesion = session()->all();
        // $allDepartamentos = "";
        // $departamento = $dataSesion['id_departamento'];

        // if ($dataSesion['rol_usuario'] == 'Super-Admin' || $dataSesion['rol_usuario'] == 'Recursos Humanos' ) {
        //     $nivel = 1;
        //     $allDepartamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();
        // }else{
        //     $nivel = 2;
        //     $departamento = $dataSesion['id_departamento'];
        // }
        // session()->put('nivel',$nivel);
        // $f = new Carbon('yesterday');
        // $fecha = $f->toDateString();
        // $maxFecha = $f->toDateString();
        // $f = new Carbon('yesterday -2 months');
        // $minFecha = $f->toDateString();

        return view('prenomina.incidencias.index');


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
        $fechaInicio = new Carbon($request->fechaInicio);
        $fechaFin = new Carbon($request->fechaFin);
        $mensaje = "";

        $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','SubDepartamento_id')->where('Departamento_id','=', $request->departamento)->where('inactivo','=',false)->get();

        $nombreDepartamento = DB::connection('merulink')->table('Departamentos')->select('nombre')->where('codigo','=', $request->departamento)->first();
        session()->put('nombre_departamento',$nombreDepartamento->nombre);
        $cantidadFechas = $diferenciaDias = $fechaFin->diffInDays($fechaInicio) + 1;
        $totalEmpleados = count($empleados);


        for ($j=0; $j < count($empleados) ; $j++) {

            $listaEmpleados[$j]['cedula'] = $empleados[$j]->cedula; //$listaCedulaEmpleados[$j]['cedula'] = $empleados[$j]->cedula;
            $listaEmpleados[$j]['nombre'] = $empleados[$j]->primer_nombre . ' ' . $empleados[$j]->primer_apellido; //$listaCedulaEmpleados[$j]['nombre'] = $empleados[$j]->primer_nombre . ' ' . $empleados[$j]->primer_apellido;
            $listaEmpleados[$j]['contIncidencia'] = 0; //$listaCedulaEmpleados[$j]['contIncidencia'] = 0;

            for ($i=0; $i < $diferenciaDias ; $i++) {

                $tmp = new Carbon($request->fechaInicio . ' +' . $i . 'days');

                $listaFechas[$i] = $tmp->toDateString();

                if ($tmp->day >= 1 && $tmp->day <= 15) {
                    $quincena[$i] = 1;
                }else{
                    $quincena[$i] = 2;
                }

                $listaEmpleados[$j]['fecha'] = $tmp->toDateString();
                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['Mensaje'] = '';
                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['MensajeEntrada'] = '';
                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['MensajeSalida'] = '';
                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = false;
                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '';
                $regIncidencias = DB::connection('ra')->table('incidencias')
                                        ->where('cedula_empleado','=', $empleados[$j]->cedula )
                                        ->where('fecha','=',$tmp->toDateString())
                                        ->first();

                if ($regIncidencias == null) {

                    $empleadoHorario[$j][$i] = DB::connection('merulink')->table('empleado_horarios')
                                            ->where('cedula_empleado','=', $empleados[$j]->cedula )
                                            ->where('mes','=',$tmp->locale('es')->monthName)
                                            ->where('quincena','=',$quincena[$i])
                                            ->first();



                    if ($empleadoHorario[$j][$i] != null) {

                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['mes']=$tmp->month;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['mes']=$tmp->locale('es')->month;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['quincena']=$quincena[$i];//
                        if ($quincena[$i] == 1) {

                            switch ($tmp->day) {
                                case 1:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D1;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D1;
                                    break;

                                case 2:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D2;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                    break;

                                case 3:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D3;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                    break;

                                case 4:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D4;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                    break;

                                case 5:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D5;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                    break;

                                case 6:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D6;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                    break;

                                case 7:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D7;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                    break;

                                case 8:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D8;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                    break;

                                case 9:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D9;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                    break;

                                case 10:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D10;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                    break;

                                case 11:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D11;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                    break;

                                case 12:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D12;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                    break;

                                case 13:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D13;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                    break;

                                case 14:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D14;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                    break;

                                case 15:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D15;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                    break;
                            }

                        }else{
                            switch ($tmp->day) {
                                case 16:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D1;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D1;
                                    break;

                                case 17:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D2;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                    break;

                                case 18:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D3;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                    break;

                                case 19:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D4;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                    break;

                                case 20:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D5;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                    break;

                                case 21:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D6;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                    break;

                                case 22:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D7;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                    break;

                                case 23:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D8;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                    break;

                                case 24:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D9;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                    break;

                                case 25:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D10;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                    break;

                                case 26:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D11;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                    break;

                                case 27:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D12;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                    break;

                                case 28:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D13;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                    break;

                                case 29:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D14;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                    break;

                                case 30:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D15;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                    break;

                                case 31:
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D16;//$resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D16;
                                    break;
                            }
                        }


                        if ($resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] == 'Libre') {
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = 'Libre';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = 'Libre';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '';
                        }else{

                            if ($resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != 'ND') {
                                $turno = DB::connection('merulink')->table('Horarios')
                                                ->where('codigo','=', $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] )
                                                ->first();

                                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = $turno->hora_entrada;
                                $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = $turno->hora_salida;
                            }


                        }


                    }else{
                        // $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['cedula'] = null;
                        // $resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['fecha']=$tmp->toDateString();
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['mes']=$tmp->month;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['quincena']=$quincena[$i];
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =null;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = null;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = null;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = false;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '';

                    }

                    $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] = DB::connection('ra')->table('asistencia')
                                                                                                            ->where('cedula','=' ,$empleados[$j]->cedula)
                                                                                                            ->where('fecha','=', $tmp->toDateString())
                                                                                                            ->first();

                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#000000';
                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';
                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = false;

                    if ($empleadoHorario[$j][$i] == null) {
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'No se le asignó turno para ésta fecha.';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                        $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;

                    }

                    if ($resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != 'Libre' && $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != null && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] == null) {
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'Ausente.';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                        $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                    }

                    if ($empleadoHorario[$j][$i] != null && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] != null) {

                        if ($resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] == 'Libre' && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_entrada != null) {
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'Entró a trabajar en su dia Libre.';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#F9BF56';
                            $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                            $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                        }else{

                            $empleadoHorarioTurnoEntrada = new Carbon($tmp->toDateString() . ' ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada']);
                            $empleadoHorarioTurnoSalida = new Carbon($tmp->toDateString() . ' ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida']);
                            $asistenciaHoraEntrada = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_entrada);

                            if ($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida_2 != null) {
                                $asistenciaHoraSalida = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida_2);
                            }else{
                                if ($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida != null)  {
                                    $asistenciaHoraSalida = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida);
                                }else{
                                    $asistenciaHoraSalida = null;
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'El empleado no marcó su salida.';
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#F9BF56';
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                                }

                            }


                            if ( $asistenciaHoraEntrada < $empleadoHorarioTurnoEntrada ) {
                                if ($asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) > 30) {
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = 'Llegó unos ' . ($asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) > 60 ? $asistenciaHoraEntrada->diffInHours($empleadoHorarioTurnoEntrada) . ' hora(s) ' : $asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) .' minutos ') . 'antes de la ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'];
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#90cc77';
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                                }
                            }

                            if ( $asistenciaHoraEntrada > $empleadoHorarioTurnoEntrada ) {
                                if ($empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) > 15) {
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = 'Llegó unos ' . ($empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) > 60 ? $empleadoHorarioTurnoEntrada->diffInHours($asistenciaHoraEntrada) . ' hora(s) ' : $empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) . ' minutos ') . 'despues de la ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'];
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                                    $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                                }
                            }

                            if ($asistenciaHoraSalida != null) {

                                if ( $asistenciaHoraSalida < $empleadoHorarioTurnoSalida ) {
                                    if ($asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) > 15) {
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = 'Salió unos ' . ($asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) > 60 ? $asistenciaHoraSalida->diffInHours($empleadoHorarioTurnoSalida) . ' hora(s) ' : $asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) . ' minutos ') . 'antes de la ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'];
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                        $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                                    }
                                }

                                if ( $asistenciaHoraSalida > $empleadoHorarioTurnoSalida ) {
                                    if ($empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) > 30) {
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = 'Salió unos ' . ($empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) > 60 ? $empleadoHorarioTurnoSalida->diffInHours($asistenciaHoraSalida) . ' hora(s) ' : $empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) . ' minutos ') . 'despues de la ' . $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'];
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#90cc77';
                                        $resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                        $listaEmpleados[$j]['contIncidencia']++;//$listaCedulaEmpleados[$j]['contIncidencia']++;
                                    }
                                }

                            }
                        }
                    }
                }


            }


        }
       //dd($listaFechas, $listaEmpleados, $resultadoEmpleadoHorario);
       return view('prenomina.incidencias.mostrar-resultados', compact('nombreDepartamento','listaFechas', 'listaEmpleados', 'resultadoEmpleadoHorario'));
    }

    public function guardarIncidencias(Request $request)
    {

        if ($request) {

            $mensaje = $request->Mensaje . ' ' . $request->MensajeEntrada . ' ' . $request->MensajeSalida;

            DB::connection('ra')->table('incidencias')->insert([
                'fecha' => $request->fecha,
                'cedula_empleado' => $request->cedula,
                'mensaje' => $mensaje,
                'observacion' => $request->observacion[$request->cedula][$request->fecha]
            ]);

            return redirect()->route('mostrar_incidencias');
        }
    }

}
