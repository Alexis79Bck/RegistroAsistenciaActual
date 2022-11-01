<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConsultarAsistencias extends Component
{
    public $data, $fecha, $cedula, $nombre, $departamento, $horaEntrada, $horaSalida, $totalHoras;

    public function mount($data){

        $this->data = $data;
        
    }


    public function render()
    {
        return view('livewire.consultar-asistencias',['data'=>$this->data]);
    }
}
