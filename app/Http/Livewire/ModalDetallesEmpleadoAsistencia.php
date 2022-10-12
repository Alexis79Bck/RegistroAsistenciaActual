<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModalDetallesEmpleadoAsistencia extends Component
{

    public $cedula;
    public $fecha;
    public $nombre;


    public function mount($Cedula, $Fecha, $Nombre )
    {
        $this->cedula = $Cedula;
        $this->cedula = $Fecha;
        $this->cedula = $Nombre;

    }

    public function render()
    {
        return view('livewire.modal-detalles-empleado-asistencia')
        ->extends('layouts.app')
        ->section('content');
    }
}
