<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarridoDatosPunchData extends Component
{
    public $nRegNuevos = 0;
    public $mensajeRegNuevos = false;
    public $cargaCompleta;
    public $nNoRegistrados;
    public $cedNoRegistrados;
    protected $listeners = ['regPunchData','contarRegNuevos'];


    public function regPunchData()
    {


        $registrosRA = DB::connection('ra')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosRA = $registrosRA->count();
        $registrosPD = DB::connection('punchdata')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosPD = $registrosPD->count();

        if ($totalRegistrosPD > $totalRegistrosRA) {
            $this->nNoRegistrados = 0;

            for ($i = 0; $i < $totalRegistrosPD - $totalRegistrosRA; $i++) {
                $empleado =  DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre', 'primer_apellido', 'Departamento_id')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->first();
                $this->numeros = $i;
                if (!empty($empleado)) {


                    $departamento = DB::connection('merulink')->table('Departamentos')->where('codigo', '=', $empleado->Departamento_id)->first();
                    $nombreCompleto = $empleado->primer_nombre . ' ' . $empleado->primer_apellido;
                    $tipoPD = 'B';
                    $horaPD = date('h:i:s a', strtotime($registrosPD[$totalRegistrosRA + $i]->PunchTime));
                    $fechaPD = date('Y-m-d', strtotime($registrosPD[$totalRegistrosRA + $i]->PunchTime));
                    $fechaAntPD = date('Y-m-d', strtotime($registrosPD[$totalRegistrosRA + $i]->PunchTime . '- 1 days'));
                    $existeRA = DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->first();
                    $existeAntRA = DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaAntPD)->where('hora_entrada','!=',null)->where('hora_salida','=',null)->first();
                    $existeAntRA_2 = DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaAntPD)->where('hora_entrada','!=',null)->where('hora_salida','!=',null)->where('hora_entrada_2','!=',null)->where('hora_salida_2','=',null)->first();

                    if (empty($existeRA)) {



                        if ($existeAntRA_2) {

                            $fechaRA=date('Y-m-d', strtotime($existeAntRA_2->hora_entrada_2));
                            $carbonFullTimePD = new carbon($registrosPD[$totalRegistrosRA + $i]->PunchTime);
                            $carbonfullHoraEntRA2 = new carbon($existeAntRA_2->hora_entrada_2);
                            $carbonFranjaRA = new carbon(date('Y-m-d H:i:s', strtotime($fechaRA . ' 14:30:00')));

                            if($carbonfullHoraEntRA2->diffInHours($carbonFullTimePD) <= 10){

                                DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaAntPD)->where('hora_entrada','!=',null)->where('hora_salida','!=',null)->where('hora_entrada_2','!=',null)->where('hora_salida_2','=',null)->update([
                                    'hora_salida_2' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                    'modo_entrada' => $existeAntRA_2->modo_entrada . ' ' . $tipoPD,
                                    'nocturno' => ($carbonfullHoraEntRA2->greaterThan($carbonFranjaRA->addHours(4)->addMinutes(30)) ? true : false)
                                ]);

                            }else{
                                    DB::connection('ra')->table('Asistencia')->insert([
                                        'cedula' => $registrosPD[$totalRegistrosRA + $i]->EnrollID,
                                        'nombre_apellido' => $nombreCompleto,
                                        'departamento' => $departamento->nombre,
                                        'fecha' => $fechaPD,
                                        'hora_entrada' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                        'modo_entrada' => $tipoPD

                                        ]);
                                }

                        }else{

                            if ($existeAntRA) {


                                $fechaRA=date('Y-m-d', strtotime($existeAntRA->hora_entrada));
                                $carbonFullTimePD = new carbon($registrosPD[$totalRegistrosRA + $i]->PunchTime);
                                $carbonfullHoraEntRA = new carbon($existeAntRA->hora_entrada);
                                $carbonFranjaRA = new carbon(date('Y-m-d H:i:s', strtotime($fechaRA . ' 14:30:00')));
//dd($existeRA, $existeAntRA, $existeAntRA_2, $fechaRA, $carbonFullTimePD,  $carbonfullHoraEntRA,$carbonFranjaRA , $carbonfullHoraEntRA->greaterThan($carbonFranjaRA),' y ', $carbonfullHoraEntRA->diffInHours($carbonFullTimePD) <= 10 );
                                if(($carbonfullHoraEntRA->greaterThan($carbonFranjaRA))&&($carbonfullHoraEntRA->diffInHours($carbonFullTimePD) <= 10)){

                                    DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaAntPD)->where('hora_entrada','!=',null)->where('hora_salida','=',null)->update([
                                        'hora_salida' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                        'modo_entrada' => $existeAntRA->modo_entrada . ' ' . $tipoPD,
                                        'nocturno' => ($carbonfullHoraEntRA->greaterThan($carbonFranjaRA->addHours(4)->addMinutes(30)) ? true : false)
                                    ]);

                                }else{
                                    DB::connection('ra')->table('Asistencia')->insert([
                                        'cedula' => $registrosPD[$totalRegistrosRA + $i]->EnrollID,
                                        'nombre_apellido' => $nombreCompleto,
                                        'departamento' => $departamento->nombre,
                                        'fecha' => $fechaPD,
                                        'hora_entrada' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                        'modo_entrada' => $tipoPD

                                        ]);
                                }

                            }else{
                                DB::connection('ra')->table('Asistencia')->insert([
                                    'cedula' => $registrosPD[$totalRegistrosRA + $i]->EnrollID,
                                    'nombre_apellido' => $nombreCompleto,
                                    'departamento' => $departamento->nombre,
                                    'fecha' => $fechaPD,
                                    'hora_entrada' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                    'modo_entrada' => $tipoPD

                                ]);
                            }


                        }

                    } else {
                        if ($existeRA->hora_salida == null) {

                            DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                                'hora_salida' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                'modo_entrada' => $existeRA->modo_entrada . ' ' . $tipoPD
                            ]);
                        } else {
                            if ($existeRA->hora_entrada_2 == null) {
                                DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                                    'hora_entrada_2' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                    'modo_entrada' => $existeRA->modo_entrada . ' ' . $tipoPD
                                ]);
                            } else {
                                if ($existeRA->hora_salida_2 == null) {

                                    DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                                        'hora_salida_2' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                                        'modo_entrada' => $existeRA->modo_entrada . ' ' . $tipoPD
                                    ]);
                                }
                            }
                        }
                    }


                    DB::connection('ra')->table('DeviceLogRegister')->insert([
                        'ID' => $registrosPD[$totalRegistrosRA + $i]->ID,
                        'EnrollID' => $registrosPD[$totalRegistrosRA + $i]->EnrollID,
                        'PunchTime' => $registrosPD[$totalRegistrosRA + $i]->PunchTime,
                        'PunchType' => $registrosPD[$totalRegistrosRA + $i]->PunchType,

                    ]);

                }else{
                    $this->nNoRegistrados++;
                    $this->cedNoRegistrados[$this->nNoRegistrados] = $registrosPD[$totalRegistrosRA + $i]->EnrollID;
                }
            }
            $this->cargaCompleta = true;

        }

    }

    public function cerrarCargaCompletaMensaje(){
        $this->cargaCompleta = false;
    }

    public function contarRegNuevos(){
        $registrosRA = DB::connection('ra')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosRA = $registrosRA->count();
        $registrosPD = DB::connection('punchdata')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosPD = $registrosPD->count();
        $this->nRegNuevos = $totalRegistrosPD - $totalRegistrosRA;
        if ($this->nRegNuevos == 0) {
            $this->mensajeRegNuevos = false;
        }
        if ($this->nRegNuevos > 0) {
            $this->mensajeRegNuevos = true;
        }

    }

    public function render()
    {

        return view('livewire.barrido-datos-punch-data');
    }
}
