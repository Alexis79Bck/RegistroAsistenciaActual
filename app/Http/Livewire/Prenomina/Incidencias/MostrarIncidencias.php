<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;

class MostrarIncidencias extends Component
{
    public $empleados;
    public $departamento;

    public function mount($empleados, $departamento)
    {
        $this->empleados = $empleados;
        $this->departamento = $departamento;

    }

    public function render()
    {
        return view('livewire.prenomina.incidencias.mostrar-incidencias');
    }
}
