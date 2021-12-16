<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BarridoDatosPunchData extends Component
{
    public $nRegNuevos;
    protected $listeners = ['regPunchData'];

    public function regPunchData()
    {
        $registrosRA = DB::connection('ra')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosRA = $registrosRA->count();
        $registrosPD = DB::connection('punchdata')->table('DeviceLogRegister')->select('ID', 'EnrollID', 'PunchTime', 'PunchType')->orderBy('ID', 'ASC')->get();
        $totalRegistrosPD = $registrosPD->count();

        if ($totalRegistrosPD > $totalRegistrosRA) {
            for ($i = 0; $i < $totalRegistrosPD - $totalRegistrosRA; $i++) {

                $empleado =  DB::connection('merulink')->table('Empleados')->select('primer_nombre', 'primer_apellido', 'Departamento_id')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->first();
                $departamento = DB::connection('merulink')->table('Departamentos')->where('codigo', '=', $empleado->Departamento_id)->first();
                $nombreCompleto = $empleado->primer_nombre . ' ' . $empleado->primer_apellido;
                $fechaPD = date('Y-m-d', strtotime($registrosPD[$totalRegistrosRA + $i]->PunchTime));
                $horaPD = $registrosPD[$totalRegistrosRA + $i]->PunchTime;
                $tipoPD = 'B';

                $existeRA = DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->first();

                if (empty($existeRA)) {
                    DB::connection('ra')->table('Asistencia')->insert([
                        'cedula' => $registrosPD[$totalRegistrosRA + $i]->EnrollID,
                        'nombre_apellido' => $nombreCompleto,
                        'departamento' => $departamento->nombre,
                        'fecha' => $fechaPD,
                        'hora_entrada' => $horaPD,
                        'modo_entrada' => $tipoPD

                    ]);
                } else {
                    if ($existeRA->hora_salida == null) {
                        DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                            'hora_salida' => $horaPD,
                            'modo_entrada' => $existeRA->modo_entrada . ' ' . $tipoPD
                        ]);
                    } else {
                        if ($existeRA->hora_entrada_2 == null) {
                            DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                                'hora_entrada_2' => $horaPD,
                                'modo_entrada' => $existeRA->modo_entrada . ' ' . $tipoPD
                            ]);
                        } else {
                            if ($existeRA->hora_salida_2 == null) {
                                DB::connection('ra')->table('Asistencia')->where('cedula', '=', $registrosPD[$totalRegistrosRA + $i]->EnrollID)->where('fecha', '=', $fechaPD)->update([
                                    'hora_salida_2' => $horaPD,
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
            }
        }
        $this->nRegNuevos = $totalRegistrosPD - $totalRegistrosRA;
    }

    public function render()
    {

        return view('livewire.barrido-datos-punch-data');
    }
}
