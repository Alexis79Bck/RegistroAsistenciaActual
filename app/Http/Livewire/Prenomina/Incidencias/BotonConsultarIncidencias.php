<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BotonConsultarIncidencias extends Component
{
    public $departamento;
    public $fechaInicio;
    public $fechaFin;
    // public $siSelectedDepartamento = false;

    protected $listeners = ['selectedDepartamento','selectedFechaInicio','selectedFechaFin'];

    public function selectedDepartamento($value) {
        // $this->siSelectedDepartamento = true;
        $this->departamento = $value;
    }

    public function selectedFechaInicio($value) {
        $this->fechaInicio = $value;
    }

    public function selectedFechaFin($value) {
        $this->fechaFin = $value;
    }

    public function enviarData(){

        if (session('rol_usuario') == 'Super-Admin' || session('rol_usuario') == 'Recursos Humanos' ) {
            if ($this->departamento == null || $this->departamento == 0) {

                return redirect()->route('incidencias')->with('mensaje-error','Debe seleccionar un departamento.');
            }

            $nombreDepartamento = DB::connection('merulink')->table('Departamentos')->select('nombre')->where('codigo','=',$this->departamento)->first();

            $data = [
                'idDepartamento' => $this->departamento,
                'nombreDepartamento' => $nombreDepartamento->nombre,
                'fechaInicio' => $this->fechaInicio,
                'fechaFin' => $this->fechaFin

            ];
        }else{

            $data = [
                'idDepartamento' => session('id_departamento'),
                'nombreDepartamento' => session('nombre_departamento'),
                'fechaInicio' => $this->fechaInicio,
                'fechaFin' => $this->fechaFin

            ];
        }
        dd($data);
        $mostrar = true;
        $this->emit('MostrarIncidencias',$data);
        $this->emit('verResultados',$mostrar  );
        // $this->reset('departamento','fechaInicio','fechaFin');
    }

    public function render() {


        return view('livewire.prenomina.incidencias.boton-consultar-incidencias');
    }
}
