<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;

class MostrarIncidencias extends Component
{

    public $departamento;
    public $listaFechas;
    public $listaCedulaEmpleados;
    public $resultadoEmpleadoHorario;


    public function mount( $departamento,  $listaFechas, $listaCedulaEmpleados, $resultadoEmpleadoHorario)
    {

        $this->departamento = $departamento;
        $this->listaFechas = $listaFechas;
        $this->listaCedulaEmpleados = $listaCedulaEmpleados;
        $this->resultadoEmpleadoHorario = $resultadoEmpleadoHorario;

    }

    public function render()
    {
        return view('livewire.prenomina.incidencias.mostrar-incidencias');
    }
}
