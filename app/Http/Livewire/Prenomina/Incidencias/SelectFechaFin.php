<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use Illuminate\Support\Carbon;

class SelectFechaFin extends Component
{
    public $maxFecha;
    public $minFecha;
    public $fecha;
    public $selectedFecha;

    protected $listeners = ['selectedFechaInicio'];

    public function mount() {
        $fecha = new Carbon('yesterday');
        $this->selectedFecha = $fecha->toDateString();
        $this->maxFecha = $fecha->toDateString();
    }

    public function selectedFechaInicio($value) {
        $this->minFecha = $value;
    }

    public function selectFechaFin($value){
        $this->emit('selectedFechaFin', $value);
        $this->selectedFecha = $value;
    }


    public function render()
    {
        $fecha = new Carbon('yesterday');
        $this->fecha = $fecha->toDateString();
        return view('livewire.prenomina.incidencias.select-fecha-fin');
    }
}
