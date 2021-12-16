<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FormularioRegistro extends Component
{
    public $empleado;
    public $selEmpleados;
    public $departamento;
    public $departamentos;
    public $cargo;
    public $nombre;
    public $apellido;
    public $cedula;
    
       
    public function mount()
    { 
       // $this->departamentos = $departamentos;
        //$this->cedula = $cedula;
       
        // $empleado = $this->empleado;
        // $departamento = $this->departamento;
    }

    public function buscaCedulaEmpleado(){
        
        $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ?',[$this->cedula]);
        if (count($this->empleado) > 0) {
            $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
            $this->cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$this->empleado[0]->Cargo_id]);
            $this->nombre = $this->empleado[0]->primer_nombre;
            $this->apellido = $this->empleado[0]->primer_apellido;
            $this->cedula = $this->empleado[0]->cedula;
            $this->departamento = $this->departamento[0]->nombre;
            $this->cargo = $this->cargo[0]->nombre;

        }
      //  dd($this->nombre, $this->apellido, $this->cedula, $this->departamento,$this->cargo);
        
     }

    public function buscaSeleccionEmpleado(){
        $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ?',[$this->selEmpleados]);
        if (count($this->empleado) > 0) {
            $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
            $this->cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$this->empleado[0]->Cargo_id]);
            $this->nombre = $this->empleado[0]->primer_nombre;
            $this->apellido = $this->empleado[0]->primer_apellido;
            $this->cedula = $this->empleado[0]->cedula;
            $this->departamento = $this->departamento[0]->nombre;
            $this->cargo = $this->cargo[0]->nombre;
            

        }
       // dd($this->nombre, $this->apellido, $this->cedula, $this->departamento,$this->cargo);
    }

   
    public function render()
    {
        
         $this->departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();
        //  $this->data =[
        //     'primer_nombre' => "Sin Nombre",
        //     'primer_apellido' => "Sin Apellido",
        //     'cedula' => "Sin cedula",
        //     'departamento' => "sin departamento",
        //     'cargo' => "sin cargo",
        // ];
        // return view('livewire.formulario-registro', compact('departamentos'));
        // if ($this->cedula != null) {
        //     $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ?',[$this->cedula]);
            
        //     $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        //     $this->cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$this->empleado[0]->Cargo_id]);
        //     $data =[
        //         'primer_nombre' => $this->empleado[0]->primer_nombre,
        //         'primer_apellido' => $this->empleado[0]->primer_apellido,
        //         'cedula' => $this->empleado[0]->cedula,
        //         'departamento' => $this->departamento[0]->nombre,
        //         'cargo' => $this->cargo[0]->nombre,
        //     ];
            //dd($data);
        //,['empleado'=>$this->empleado[0],'departamento'=>$this->departamento,'cargo'=>$this->cargo]
        
        
        return view('livewire.formulario-registro',['departamentos'=>$this->departamentos, 'nombre'=>$this->nombre, 'apellido'=>$this->apellido, 'cedula'=>$this->cedula, 'departamento'=>$this->departamento, 'cargo'=>$this->cargo]);
    }
}
