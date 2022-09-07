<?php

namespace App\Http\Livewire\Prenomina\Resumen;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MostrarResumen extends Component
{

    public $departamentos;
    public $selectedDepartamento;

     public function updatedSelectedDepartamento($value) {
        $this->selectedDepartamento = $value;
    }

    public function mostrarResumen() {
        $this->emit('LimpiarResumen');
        if ($this->selectedDepartamento == null || $this->selectedDepartamento == '-- Seleccione --') {
            return redirect()->route('resumen')->with('mensaje-advertencia', 'Seleccione un departamento');
        }else{

            $departamento = DB::connection('merulink')->table('Departamentos')->select('nombre')->where('codigo', '=', $this->selectedDepartamento)->first();
            $data = [
                'id_departamento' => $this->selectedDepartamento,
                'nombreDepartamento' => $departamento->nombre,

            ];

            $this->emit('MostrarResumen', $data);
        }

    }

    public function render()
    {
        $this->departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();

        return view('livewire.prenomina.resumen.mostrar-resumen');
    }
}
