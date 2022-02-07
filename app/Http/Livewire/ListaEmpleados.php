<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonTimeZone;

class ListaEmpleados extends Component
{
    public $fecha, $hrEnt, $hrSal, $empleados, $empleadosControl, $departamentos, $dataControl = [];

    protected $listeners = ['lafecha2'];


    public function lafecha2($fecha){
        $this->reset('dataControl');

        $this->fecha = new Carbon($fecha);
        $this->empleados = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id from Empleados where id > 999 and inactivo <> 1');

        $this->empleadosControl = DB::connection('ra')->table('asistencia')->where('fecha','=', date('Y-m-d',strtotime($this->fecha)))->get();

        if (count($this->empleadosControl) > 0) {
           $l=1;
            foreach ($this->empleados as $registro) {
                $mdEnt = '';
                $m = 0;
                    foreach ($this->empleadosControl  as $registro2) {

                        if ($registro->cedula == $registro2->cedula){
                            $m = 1;
                            $mdEnt = $registro2->modo_entrada;

                            break;
                        }
                    }

                    $this->dataControl[$l] =[
                        'cedula' => $registro->cedula,
                        'nombre' => $registro->primer_nombre . ' ' .$registro->primer_apellido,
                        'departamento_id' => $registro->Departamento_id,
                        'HoraEntrada' =>  date('h:i a', strtotime($registro2->hora_entrada)),
                        'HoraEntrada2' =>  $registro2->hora_entrada_2 != null ? date('h:i a', strtotime($registro2->hora_entrada_2)) : '',
                        'HoraSalida' =>  $registro2->hora_salida != null ? date('h:i a', strtotime($registro2->hora_salida)) : '',
                        'HoraSalida2' =>  $registro2->hora_salida_2 != null ? date('h:i a', strtotime($registro2->hora_salida_2)) : '',
                        'ModoEntrada' => $mdEnt,
                        'Nocturno' => $registro2->nocturno,
                        'pinta' => $m
                    ];

                  $l++;
            }
        }else{
            $this->dataControl = 0;
        }


    }

    public function render()
    {
        $this->empleados = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id from Empleados where id > 999 and inactivo <> 1');

        $this->departamentos = DB::connection('merulink')->select('select codigo, nombre from Departamentos where codigo != 0');
        $this->empleadosControl = DB::connection('ra')->table('asistencia')->where('fecha','=', date('Y-m-d',strtotime($this->fecha)))->get();


        return view('livewire.lista-empleados', ['empleados'=>$this->empleados,'departamentos'=>$this->departamentos,'empleadosControl' => $this->empleadosControl, 'dataControl' => $this->dataControl]);
    }
}
