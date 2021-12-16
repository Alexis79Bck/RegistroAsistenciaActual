<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BuscaEmpleadoPorCedula extends Component
{
    public $cargo;
    public $empleado;
    public $departamento;
    public $cedula;
    public $data;

     public function buscaEmpleado(){
        $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ?',[$this->cedula]);
        
        $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        $this->cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$this->empleado[0]->Cargo_id]);
    //     $this->empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id from Empleados where cedula = ?',[$this->cedula]);
    //     $this->departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$this->empleado[0]->Departamento_id]);
        //dd($this->empleado, $this->departamento, $this->cargo);
    //     $request->session()->put(['empleado'=>$this->empleado,'departamento'=>$this->departamento]);
        $this->data =[
            'primer_nombre' => $this->empleado[0]->primer_nombre,
            'primer_apellido' => $this->empleado[0]->primer_apellido,
            'cedula' => $this->empleado[0]->cedula,
            'departamento' => $this->departamento[0]->nombre,
            'cargo' => $this->cargo[0]->nombre,
        ];
        dd($this->data);
        
     }
    public function render()
    {
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

           
        // }else{
        //     $data = "";
        // }
        
        return view('livewire.busca-empleado-por-cedula',['data'=>$this->data]);
    }
}
