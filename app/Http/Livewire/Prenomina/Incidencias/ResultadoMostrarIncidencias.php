<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoMostrarIncidencias extends Component
{
    public $nombreDepartamento;
    public $totalEmpleados;
    public $cantidadFechas;
    public $listaFechas;
    public $listaEmpleados;
    public $resultadoEmpleadoHorario;
    public $siResultado = false;
    protected $listeners = ['MostrarIncidencias'=> 'mostrarResultado','LimpiarResultado'=>'Limpiar' , 'verResultados' => 'verResultados' ];

    public function Limpiar() {
        $this->reset('nombreDepartamento', 'totalEmpleados', 'cantidadFechas','listaFechas', 'listaEmpleados','resultadoEmpleadoHorario','siResultado');
    }

    public function verResultados($mostrar) {
        $this->siResultado = $mostrar;
    }

    public function mostrarResultado($data){

        $fechaInicio = new Carbon($data['fechaInicio']);
        $fechaFin = new Carbon($data['fechaFin']);

        $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','SubDepartamento_id')->where('Departamento_id','=', $data['id_departamento'])->where('inactivo','=',false)->get();
        $NmDepto = DB::connection('merulink')->table('Departamentos')->select('nombre')->where('codigo','=', $data['id_departamento'])->first();

        $this->nombreDepartamento = $NmDepto->nombre;

        $this->cantidadFechas = $diferenciaDias = $fechaFin->diffInDays($fechaInicio) + 1;
        $this->totalEmpleados = count($empleados);


        for ($j=0; $j < count($empleados) ; $j++) {

            $this->listaEmpleados[$j]['cedula'] = $empleados[$j]->cedula;
            $this->listaEmpleados[$j]['nombre'] = $empleados[$j]->primer_nombre . ' ' . $empleados[$j]->primer_apellido;
            $this->listaEmpleados[$j]['contIncidencia'] = 0;

            for ($i=0; $i < $diferenciaDias ; $i++) {

                $tmp = new Carbon($data['fechaInicio'] . ' +' . $i . 'days');

                $this->listaFechas[$i] = $tmp->toDateString();

                if ($tmp->day >= 1 && $tmp->day <= 15) {
                    $quincena[$i] = 1;
                }else{
                    $quincena[$i] = 2;
                }

                $this->listaEmpleados[$j]['fecha'] = $tmp->toDateString();
                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';
                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '';
                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = '';

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

                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['mes']=$tmp->month;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['quincena']=$quincena[$i];

                        if ($quincena[$i] == 1) {

                            switch ($tmp->day) {
                                case 1:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D1;
                                    break;

                                case 2:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D2;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                    break;

                                case 3:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D3;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                    break;

                                case 4:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D4;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                    break;

                                case 5:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D5;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                    break;

                                case 6:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D6;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                    break;

                                case 7:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D7;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                    break;

                                case 8:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D8;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                    break;

                                case 9:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D9;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                    break;

                                case 10:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D10;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                    break;

                                case 11:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D11;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                    break;

                                case 12:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D12;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                    break;

                                case 13:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D13;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                    break;

                                case 14:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D14;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                    break;

                                case 15:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D15;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                    break;
                            }

                        }else{
                            switch ($tmp->day) {
                                case 16:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D1;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D1;
                                    break;

                                case 17:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D2;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D2;
                                    break;

                                case 18:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D3;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D3;
                                    break;

                                case 19:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D4;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D4;
                                    break;

                                case 20:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D5;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D5;
                                    break;

                                case 21:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D6;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D6;
                                    break;

                                case 22:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D7;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D7;
                                    break;

                                case 23:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D8;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D8;
                                    break;

                                case 24:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D9;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D9;
                                    break;

                                case 25:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D10;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D10;
                                    break;

                                case 26:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D11;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D11;
                                    break;

                                case 27:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D12;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D12;
                                    break;

                                case 28:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D13;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D13;
                                    break;

                                case 29:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D14;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D14;
                                    break;

                                case 30:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D15;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D15;
                                    break;

                                case 31:
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =  $empleadoHorario[$j][$i]->D16;//$this->resultadoEmpleadoHorario[$tmp->toDateString()][$empleados[$j]->cedula]['codTurno'] =  $empleadoHorario[$i][$j]->D16;
                                    break;
                            }
                        }


                        if ($this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] == 'Libre') {
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = 'Libre';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = 'Libre';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';

                        }else{

                            if ($this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != 'ND') {
                                $turno = DB::connection('merulink')->table('Horarios')
                                                ->where('codigo','=', $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] )
                                                ->first();

                                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = $turno->hora_entrada;
                                $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = $turno->hora_salida;
                            }


                        }


                    }else{

                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['mes']=$tmp->month;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['quincena']=$quincena[$i];
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] =null;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'] = null;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'] = null;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = false;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';

                    }

                    $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] = DB::connection('ra')->table('asistencia')
                                                                                                            ->where('cedula','=' ,$empleados[$j]->cedula)
                                                                                                            ->where('fecha','=', $tmp->toDateString())
                                                                                                            ->first();

                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#000000';
                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = '';
                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = '';
                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = '';
                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = false;

                    if ($empleadoHorario[$j][$i] == null) {
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'No se le asignó turno para ésta fecha.';
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                        $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;

                    }

                    if ($this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != 'Libre' && $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] != null && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] == null) {
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'Ausente.';
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                        $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                    }

                    if ($empleadoHorario[$j][$i] != null && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro'] != null) {

                        if ($this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['codTurno'] == 'Libre' && $Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_entrada != null) {
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'Entró a trabajar en su dia Libre.';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#F9BF56';
                            $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                            $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                        }else{

                            $empleadoHorarioTurnoEntrada = new Carbon($tmp->toDateString() . ' ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada']);
                            $empleadoHorarioTurnoSalida = new Carbon($tmp->toDateString() . ' ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida']);
                            $asistenciaHoraEntrada = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_entrada);

                            if ($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida_2 != null) {
                                $asistenciaHoraSalida = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida_2);
                            }else{
                                if ($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida != null)  {
                                    $asistenciaHoraSalida = new Carbon($Asistencia[$empleados[$j]->cedula][$tmp->toDateString()]['Registro']->hora_salida);
                                }else{
                                    $asistenciaHoraSalida = null;
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['Mensaje'] = 'El empleado no marcó su salida.';
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#F9BF56';
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                                }

                            }


                            if ( $asistenciaHoraEntrada < $empleadoHorarioTurnoEntrada ) {
                                if ($asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) > 30) {
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = 'Llegó unos ' . ($asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) > 60 ? $asistenciaHoraEntrada->diffInHours($empleadoHorarioTurnoEntrada) . ' hora(s) ' : $asistenciaHoraEntrada->diffInMinutes($empleadoHorarioTurnoEntrada) .' minutos ') . 'antes de la ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'];
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#90cc77';
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                                }
                            }

                            if ( $asistenciaHoraEntrada > $empleadoHorarioTurnoEntrada ) {
                                if ($empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) > 15) {
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeEntrada'] = 'Llegó unos ' . ($empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) > 60 ? $empleadoHorarioTurnoEntrada->diffInHours($asistenciaHoraEntrada) . ' hora(s) ' : $empleadoHorarioTurnoEntrada->diffInMinutes($asistenciaHoraEntrada) . ' minutos ') . 'despues de la ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraEntrada'];
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                                    $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                    $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                                }
                            }

                            if ($asistenciaHoraSalida != null) {

                                if ( $asistenciaHoraSalida < $empleadoHorarioTurnoSalida ) {
                                    if ($asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) > 15) {
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = 'Salió unos ' . ($asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) > 60 ? $asistenciaHoraSalida->diffInHours($empleadoHorarioTurnoSalida) . ' hora(s) ' : $asistenciaHoraSalida->diffInMinutes($empleadoHorarioTurnoSalida) . ' minutos ') . 'antes de la ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'];
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#f65e5e';
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                        $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                                    }
                                }

                                if ( $asistenciaHoraSalida > $empleadoHorarioTurnoSalida ) {
                                    if ($empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) > 30) {
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['MensajeSalida'] = 'Salió unos ' . ($empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) > 60 ? $empleadoHorarioTurnoSalida->diffInHours($asistenciaHoraSalida) . ' hora(s) ' : $empleadoHorarioTurnoSalida->diffInMinutes($asistenciaHoraSalida) . ' minutos ') . 'despues de la ' . $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['TurnoHoraSalida'];
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['ColorIncidencia'] = '#90cc77';
                                        $this->resultadoEmpleadoHorario[$empleados[$j]->cedula][$tmp->toDateString()]['HayIncidencia'] = true;
                                        $this->listaEmpleados[$j]['contIncidencia']++;//$this->listaCedulaEmpleados[$j]['contIncidencia']++;
                                    }
                                }

                            }
                        }
                    }
                }


            }


        }

    }

    public function render()
    {

        return view('livewire.prenomina.incidencias.resultado-mostrar-incidencias');
    }
}
