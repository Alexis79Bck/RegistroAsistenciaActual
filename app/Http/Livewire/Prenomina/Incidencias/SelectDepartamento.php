<?php

namespace App\Http\Livewire\Prenomina\Incidencias;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class SelectDepartamento extends Component
{
    public $departamento;


    public function selectDepartamento($value){

        $this->departamento = $value;
        $this->emit('selectedDepartamento', $value);

    }

    public function hiddenDepartamento(){

        $this->departamento = session('id_departamento');
        $this->emit('selectedDepartamento', session('id_departamento'));

    }

    public function render()
    {
        if (session('rol_usuario') != 'Super-Admin' && session('rol_usuario') != 'Recursos Humanos') {
            $this->departamento = session('id_departamento');
        }
        $allDepartamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();

        return view('livewire.prenomina.incidencias.select-departamento', compact('allDepartamentos'));
    }
}
