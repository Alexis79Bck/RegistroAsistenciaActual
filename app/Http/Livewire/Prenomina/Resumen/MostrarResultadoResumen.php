<?php

namespace App\Http\Livewire\Prenomina\Resumen;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MostrarResultadoResumen extends Component
{

    public $nombreDepartamento;
    public $nombreSubdepto;
    public $data;
    public $contFechas ;
    public $contSubdeptos ;
    public $contEmpleados ;
    public $listaCedulas;
    public $tieneEmpleado = false;
    public $mostrar = false;
    public $periodo;
    protected $listeners = ['MostrarResumen'=> 'mostrarResultado','LimpiarResumen'=>'Limpiar' , 'verResumen' => 'verResultados' ];

    public function Limpiar() {
        $this->reset( 'mostrar','contFechas', 'nombreSubdepto','data', 'contSubdeptos','contEmpleados','listaCedulas','tieneEmpleado');
    }

    public function mostrarResultado($data)
    {
        $this->mostrar = true;
        $this->nombreDepartamento = $data['nombreDepartamento'];
        $subDeptos = DB::connection('merulink')->table('sub_departamentos')->where('Departamento_id', '=', $data['id_departamento'])->get()->toArray();
        $fechaInicio  = new Carbon('last friday');
        $fechaFin = new Carbon('next friday');
        $fechaActual = new Carbon('now');
        $this->periodo = [
            'desde' => $fechaInicio->format('d-m-Y'),   //toDateString(),
            'hasta' => $fechaActual->format('d-m-Y')   //toDateString(),
        ];
        if ($fechaActual->lte($fechaFin)) {
            $this->contFechas = $contFechas = $fechaActual->diffInDays($fechaInicio);
        }
        if (!empty($subDeptos)) {
            $this->contSubdeptos = count($subDeptos);
        }else{
            $this->contSubdeptos = 0;
        }

        if ($this->contSubdeptos > 0) {
            for ($k=0; $k < count($subDeptos) ; $k++) {

                $this->nombreSubdepto[$k] = $subDeptos[$k]->nombre;

                $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','Departamento_id','SubDepartamento_id')
                            ->where('Departamento_id', '=', $data['id_departamento'])
                            ->where('SubDepartamento_id', '=', $subDeptos[$k]->codigo)
                            ->where('inactivo','=',false)->get();

                $this->contEmpleados[$k] = count($empleados);
                $this->tieneEmpleado[$k] = count($empleados) > 0 ? true : false;
                if ( $this->tieneEmpleado) {


                    for ($j = 0; $j < count($empleados); $j++) {

                        $diasTrab = 0;
                        $feriadoTrab = 0;
                        $domingoTrab = 0;
                        $diasTurnoMxTrab = 0;
                        $diasTurnoNocTrab = 0;

                        $this->listaCedulas[$k][$j] = $empleados[$j]->cedula;

                        for ($i = 0; $i < $contFechas; $i++) {
                            $fechaX = new Carbon($fechaInicio->toDateString() . ' +' . $i . ' days');
                            $asistenciaEmp = DB::connection('ra')->table('asistencia')->where('cedula', '=', $empleados[$j]->cedula)->where('fecha', '=', $fechaX->toDateString())->first();

                            if (!empty($asistenciaEmp)) {
                                $diasTrab++;
                                $esFeriado = DB::connection('merulink')->table('dia_festivos')->where('dia', '=', $fechaX->day)->where('mes', '=', $fechaX->month)->exists();
                                if ($esFeriado) {
                                    $feriadoTrab++;
                                }

                                if ($fechaX->isSunday()) {
                                    $domingoTrab++;
                                }

                                $entrada = new Carbon($asistenciaEmp->hora_entrada);
                                $entradaTurnoMx = new Carbon($fechaX->toDateString() . ' 14:45:00.00');
                                $entradaTurnoNoc = new Carbon($fechaX->toDateString() . ' 22:45:00.00');

                                if ($entrada->isBetween($entradaTurnoMx, $entradaTurnoNoc)) {
                                    $diasTurnoMxTrab++;
                                }
                                if ($entrada->gte($entradaTurnoNoc)) {
                                    $diasTurnoNocTrab++;
                                }

                            }


                        }


                        $this->data[$subDeptos[$k]->nombre][$empleados[$j]->cedula] = [

                            'nombreCompleto' => $empleados[$j]->primer_nombre . ' ' . $empleados[$j]->primer_apellido,
                            'texto' => 'Este empleado trabajo este dia.',
                            'diasTrab' => $diasTrab,
                            'feriadoTrab' => $feriadoTrab,
                            'domingoTrab' => $domingoTrab,
                            'diasTurnoMx' => $diasTurnoMxTrab,
                            'diasTurnoNoc' => $diasTurnoNocTrab
                        ];

                    }

                }

            }

        } else {
            $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','Departamento_id','SubDepartamento_id')
                            ->where('Departamento_id', '=', $data['id_departamento'])
                            ->where('inactivo','=',false)->get();
            $this->contEmpleados[0] = count($empleados);
            for ($j = 0; $j < count($empleados); $j++) {

                $diasTrab = 0;
                $feriadoTrab = 0;
                $domingoTrab = 0;
                $diasTurnoMxTrab = 0;
                $diasTurnoNocTrab = 0;
                $this->listaCedulas[$j] = $empleados[$j]->cedula;
                for ($i = 0; $i < $contFechas; $i++) {
                    $fechaX = new Carbon($fechaInicio->toDateString() . ' +' . $i . ' days');
                    $asistenciaEmp = DB::connection('ra')->table('asistencia')->where('cedula', '=', $empleados[$j]->cedula)->where('fecha', '=', $fechaX->toDateString())->first();

                    if (!empty($asistenciaEmp)) {
                        $diasTrab++;
                        $esFeriado = DB::connection('merulink')->table('dia_festivos')->where('dia', '=', $fechaX->day)->where('mes', '=', $fechaX->month)->exists();
                        if ($esFeriado) {
                            $feriadoTrab++;
                        }

                        if ($fechaX->isSunday()) {
                            $domingoTrab++;
                        }

                        $entrada = new Carbon($asistenciaEmp->hora_entrada);
                        $entradaTurnoMx = new Carbon($fechaX->toDateString() . ' 14:45:00.00');
                        $entradaTurnoNoc = new Carbon($fechaX->toDateString() . ' 22:45:00.00');

                        if ($entrada->isBetween($entradaTurnoMx, $entradaTurnoNoc)) {
                            $diasTurnoMxTrab++;
                        }
                        if ($entrada->gte($entradaTurnoNoc)) {
                            $diasTurnoNocTrab++;
                        }

                    }


                }


                $this->data[$j] = [

                    'nombreCompleto' => $empleados[$j]->primer_nombre . ' ' . $empleados[$j]->primer_apellido,
                    'texto' => 'Este empleado trabajo este dia.',
                    'diasTrab' => $diasTrab,
                    'feriadoTrab' => $feriadoTrab,
                    'domingoTrab' => $domingoTrab,
                    'diasTurnoMx' => $diasTurnoMxTrab,
                    'diasTurnoNoc' => $diasTurnoNocTrab
                ];

            }


        }


        //dd($empleados, $this->listaCedulas, $this->data);


    }
    public function render()
    {
        return view('livewire.prenomina.resumen.mostrar-resultado-resumen');
    }
}
