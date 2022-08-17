<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use App\Models\Incidencia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MostrarIncidencias extends Component
{

    public $departamentos;
    public $selectedDepartamento;
    public $fecha;
    public $maxFecha;
    public $minFecha;
    public $selectedFechaIni;
    public $selectedFechaFin;
    public $nivel;
    public $listaFechas;
    public $listaCedulaEmpleados;
    public $resultadoEmpleadoHorario;

    // public function mount( $departamento,  $listaFechas, $listaCedulaEmpleados, $resultadoEmpleadoHorario)
    // {

    //     $this->departamento = $departamento;
    //     $this->listaFechas = $listaFechas;
    //     $this->listaCedulaEmpleados = $listaCedulaEmpleados;
    //     $this->resultadoEmpleadoHorario = $resultadoEmpleadoHorario;

    // }

    // public function getDepartamento($value) {
    //     $this->departamento = $value;
    // }

    public function updatedSelectedDepartamento($value) {
        $this->selectedDepartamento = $value;
    }

    public function updatedSelectedFechaIni($value) {
        $this->selectedFechaIni = $value;
    }

    public function updatedSelectedFechaFin($value) {
        $this->selectedFechaFin = $value;
    }

    public function mostrarResultado() {
        $this->emit('LimpiarResultado');
        if ($this->selectedDepartamento == null) {
            return redirect()->route('incidencias')->with('mensaje-advertencia', 'Seleccione un departamento');
        }elseif ($this->selectedFechaIni == null) {
            return redirect()->route('incidencias')->with('mensaje-advertencia', 'Seleccione una fecha inicio');
        } elseif ($this->selectedFechaFin == null) {
            return redirect()->route('incidencias')->with('mensaje-advertencia', 'Seleccione una fecha final');
        }else {
            $data = [
                'id_departamento' => $this->selectedDepartamento,
                'fechaInicio' => $this->selectedFechaIni,
                'fechaFin' => $this->selectedFechaFin,
            ];

            $this->emit('MostrarIncidencias', $data);
        }



    }

    public function render()
    {
        $dataSesion = session()->all();

        if ($dataSesion['rol_usuario'] == 'Super-Admin' || $dataSesion['rol_usuario'] == 'Recursos Humanos' ) {
            $this->nivel = 1;
            $this->departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();
        }else{
            $this->nivel = 2;
            $this->departamentos = "";
            $this->selectedDepartamento = $dataSesion['id_departamento'];
        }

        $f = new Carbon('yesterday');
        $this->fecha = $f->toDateString();
        $this->maxFecha = $f->toDateString();
        $f = new Carbon('yesterday -2 months');
        $this->minFecha = $f->toDateString();
        return view('livewire.prenomina.incidencias.mostrar-incidencias');
    }
}
