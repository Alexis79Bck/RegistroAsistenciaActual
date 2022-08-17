<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use Illuminate\Support\Carbon;

class SelectFechaInicio extends Component
{
    public $maxFecha;
    public $minFecha;
    public $fecha;
    public $selectedFecha;

    public function mount(){
        $fecha = new Carbon('yesterday');
        $this->selectedFecha = $fecha->toDateString();
        $this->maxFecha = $fecha->toDateString();
        $fecha = new Carbon('yesterday -3 months');
        $this->minFecha = $fecha->toDateString();
    }

    public function selectFechaInicio($value){
        $this->emit('selectedFechaInicio', $value);
        $this->selectedFecha = $value;

    }

    public function render()
    {
        $fecha = new Carbon('yesterday');
        $this->fecha = $fecha->toDateString();
        return view('livewire.prenomina.incidencias.select-fecha-inicio');
    }
}
