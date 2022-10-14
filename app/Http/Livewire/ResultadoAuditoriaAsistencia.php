<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class ResultadoAuditoriaAsistencia extends Component
{

    protected $request;
    public $fechaInicio;
    public $fechaFin;
    public $porDia;
    public $consultarPor;
    public $selectedDepartamento;
    public $selectedEmpleado;
    public $cedula;



    public function mount(Request $request )
    {
        $this->request = $request;
        $this->fechaInicio = $request->fechaInicio;
        $this->fechaFin = $request->fechaFin ?? null;
        $this->porDia = $request->consultaHoy ?? null;
        $this->consultarPor = $request->consultaPor ?? null;
        $this->selectedDepartamento = $request->departamento ?? null;
        $this->selectedEmpleado = $request->empleadoDepartamento ?? null;
        $this->cedula = $request->cedula ?? null;

        $this->selectedPorDia($this->porDia);

        //$this->fechaFin = $request->exists('fechaFin') ? $request->fechaFin : null;
        //$this->porDia = $request->exists('consultaHoy') ? $request->consultaHoy : null;

        dd('estoy en livewire.', $this->all(), $this->request);

    }

    private function selectedPorDia($value)
    {
        if($value != null )
        {
            dd($this->fechaInicio, 'en el privado de selectedPorDia');
        }
    }

    public function render()
    {
        return view('livewire.resultado-auditoria-asistencia')
        ->extends('layouts.app')
        ->section('content');
    }
}
