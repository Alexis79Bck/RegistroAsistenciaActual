<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscaEmpleadoPorSeleccion extends Component
{
    public $cargo;
    public $empleado;
    public $departamento;
    public $cedula;
    public $data2;

     public function buscaEmpleado(){
        $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ?',[$this->cedula]);
        
        $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        $this->cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$this->empleado[0]->Cargo_id]);
    //     $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id from Empleados where cedula = ?',[$this->cedula]);
    //     $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        //dd($this->empleado, $this->departamento, $this->cargo);
    //     $request->session()->put(['empleado'=>$this->empleado,'departamento'=>$this->departamento]);
        $this->$data2 =[
            'primer_nombre' => $this->empleado[0]->primer_nombre,
            'primer_apellido' => $this->empleado[0]->primer_apellido,
            'cedula' => $this->empleado[0]->cedula,
            'departamento' => $this->departamento[0]->nombre,
            'cargo' => $this->cargo[0]->nombre,
        ];
        
     }
    public function render()
    {
        return view('livewire.busca-empleado-por-seleccion',['data'=>$this->data2]);
    }
}
