<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConsultarAsistencias extends Component
{
    public $data, $fecha, $cedula, $nombre, $departamento, $horaEntrada, $horaSalida, $totalHoras;

    public function mount($data){
        
        // $this->fecha = $data['fecha'];
        // $this->cedula = $data['cedula'];
        // $this->nombre = $data['nombre'];
        // $this->departamento = $data['departamento'];
        // $this->horaEntrada = $data['horaEntrada'];
        // $this->horaSalida = $data['horaSalida'];
        // $this->totalHoras = $data['totalHoras'];
        $this->data = $data;

    }

    public function resultadoConsulta(Request $request) {
        dd($request);
        if ($request) {
            dd($request);
        }
    }
    public function render()
    {
        return view('livewire.consultar-asistencias',['data'=>$this->data]);
    }
}
