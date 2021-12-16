<?php

namespace App\Http\Livewire; 

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BusquedaEmpleado extends Component
{

   //public $departamentos;
   public $cedula;
   public $empleado;
   public $departamento;
   public $departamentos;
    // public function buscarEmpleado() {
    //     $this->empleados = DB::connection('merulink')->table('Empleados')->where('cedula','=','14441120')->first();
    // }
    public function mount($departamentos)
    { 
     // $this->cedula = $cedula;
     
     $this->departamentos = $departamentos;
       
    }

    public function buscaPorCedula(){
        
        $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id from Empleados where cedula = ?',[$this->cedula]);
        $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        
    }
    public function render()
    {
       
        // $empleado = $this->empleado;
        // $departamento = $this->departamento;
        
        
        //return view('livewire.busqueda-empleado', ['departamentos'=>$this->departamentos,'empleado'=>$this->empleado, 'departamento'=>$this->departamento]);
        return view('livewire.busqueda-empleado', ['departamentos'=>$this->departamentos])->with(['empleado'=>$this->empleado,'departamento'=>$this->departamento]);
    }
}
