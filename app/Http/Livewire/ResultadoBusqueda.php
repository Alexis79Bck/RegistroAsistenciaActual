<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ResultadoBusqueda extends Component
{
    
    public $data;
    public $nombre;
    public $apellido;
    public $cedula;
    public $departamento;
    public $cargo;

    public function mount(){

      
        
        
    }
    // public function mount($empleado, $departamento, $cargo){
    //     $this->primer_nombre = $empleado->primer_nombre;
    //     $this->primer_apellido = $empleado->primer_apellido;
    //     $this->cedula = $empleado->cedula;
    //     $this->departamento = $departamento->nombre;
    //     $this->cargo = $cargo->nombre;
    // }

    public function render()
    {
        
        return view('livewire.resultado-busqueda');
    }
}
