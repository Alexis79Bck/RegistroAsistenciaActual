<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

class BotonGuardarIncidencias extends Component
{
    public $cedula;
    public $fecha;
    public $resultado;
    public $departamento_id;

    public function mount($resultado, $cedula, $fecha) {
        $this->cedula = $cedula;
        $this->fecha = $fecha;
        $this->resultado = $resultado;
        //dd($this->all());
    }


    public function render()
    {

        return view('livewire.prenomina.incidencias.boton-guardar-incidencias');
    }
}


