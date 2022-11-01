<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoAuditoriaAsistencia extends Component
{

    public $optionNumber;
    public $resultado;
    public $fechaInicio;
    public $fechaFin;
    public $titulo;
    public $consultarPor;
    public $arrayRequest;



    public function mount(Request $request )
    {

        $this->arrayRequest = $request->except('_token');
        $this->fechaInicio = $request->fechaInicio;
        $this->fechaFin = $request->fechaFin ?? null;
        $this->selectedOptions($this->arrayRequest);

    }

    protected function selectedPorDia($fecha)
    {
        $this->reset('resultado');
        $departamentos = $this->getDepartamentos();
        foreach ($departamentos as  $index => $departamento )
        {
            $empleados = $this->getEmpleadosPorDepartamento($departamento->codigo);
            foreach ($empleados as $index2 => $empleado) {

                $this->resultado[$index][$index2] =[
                    'Departamento' => $departamento->nombre,
                    'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                    'Registros' => $this->getRegistrosPorDia($empleado->cedula, $fecha)
                ];


            }

        }


    }

    private function selectedPorRango($fecha1, $fecha2)
    {
        $this->reset('resultado');
        $departamentos = $this->getDepartamentos();
        foreach ($departamentos as  $index => $departamento )
        {
            $empleados = $this->getEmpleadosPorDepartamento($departamento->codigo);
            foreach ($empleados as $index2 => $empleado) {

                $this->resultado[$index][$index2] =[
                   'Departamento' => $departamento->nombre,
                   'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                   'Registros' => $this->getRegistrosPorRango($empleado->cedula, $fecha1, $fecha2)
                ];

            }

        }

    }

    private function selectedPorDepartamentoYRango($fecha1, $fecha2, $departamentoId, $empleadoCed)
    {
        $this->reset('resultado');
        $departamento = $this->getDepartamento($departamentoId);
        if ($empleadoCed == 'Todos'){
            $this->optionNumber = 3;
            $this->titulo = 'Consulta por Rango de Fecha | Un Departamento | Todos los Empleados';
            $empleados = $this->getEmpleadosPorDepartamento($departamentoId);

            foreach ($empleados as $index => $empleado) {

                $this->resultado[$index] =[
                    'Departamento' => $departamento->nombre,
                    'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                    'Registros' => $this->getRegistrosPorRango($empleado->cedula, $fecha1, $fecha2)
                ];

            }

        }else{
            $this->optionNumber = 4;
            $this->titulo = 'Consulta por Rango de Fecha | Un Departamento | Un Empleado';
            $empleado = $this->getEmpleadoPorDepartamento($empleadoCed, $departamento->codigo);

            $this->resultado=[
                'Departamento' => $departamento->nombre,
                'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                'Registros' => $this->getRegistrosPorRango($empleado->cedula, $fecha1, $fecha2)
            ];

        }


    }

    private function selectedPorDepartamentoYDia($fecha1, $departamentoId, $empleadoCed)
    {
        $this->reset('resultado');
        $departamento = $this->getDepartamento($departamentoId);

        if ($empleadoCed == 'Todos'){
            $this->optionNumber = 5;
            $this->titulo = 'Consulta por una Fecha | Un Departamento | Todos los Empleados';
            $empleados = $this->getEmpleadosPorDepartamento($departamentoId);
            foreach ($empleados as $index => $empleado) {

                $this->resultado[$index] =[
                    'Departamento' => $departamento->nombre,
                    'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                    'Registros' => $this->getRegistrosPorDia($empleado->cedula, $fecha1)
                ];

            }

        }else{
            $this->optionNumber = 6;
            $this->titulo = 'Consulta por una Fecha | Un Departamento | Un Empleado';
            $empleado = $this->getEmpleadoPorDepartamento($empleadoCed, $departamento->codigo);

            $this->resultado =[
                'Departamento' => $departamento->nombre,
                'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
                'Registros' => $this->getRegistrosPorDia($empleado->cedula, $fecha1)
            ];


        }

    }

    private function selectedPorCedulaYRango($fecha1, $fecha2,  $empleadoCed)
    {
        $this->reset('resultado');
        $empleado = $this->getEmpleadoPorCedula($empleadoCed);
        $departamento = $this->getDepartamento($empleado->Departamento_id);

        $this->resultado =[
            'Departamento' => $departamento->nombre,
            'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
            'Registros' => $this->getRegistrosPorRango($empleado->cedula, $fecha1, $fecha2)
        ];

    }

    private function selectedPorCedulaYDia($fecha1,  $empleadoCed)
    {
        $this->reset('resultado');
        $empleado = $this->getEmpleadoPorCedula($empleadoCed);
        $departamento = $this->getDepartamento($empleado->Departamento_id);

        $this->resultado =[
            'Departamento' => $departamento->nombre,
            'Empleado' => $this->getNombreEmpleadoCompleto($empleado),
            'Registros' => $this->getRegistrosPorDia($empleado->cedula, $fecha1)
        ];


    }

    private function selectedOptions(array $array)
    {

        if (array_key_exists('fechaFin', $array) && !array_key_exists('consultaHoy', $array) && !array_key_exists('consultaPor', $array))
        {
            $this->optionNumber = 1;
            $this->titulo = 'Consulta por Rango de Fecha | Todos los Departamentos | Todos los Empleados';
            $this->selectedPorRango($array['fechaInicio'], $array['fechaFin']);
        }
        if (array_key_exists('consultaHoy', $array))
        {
            $this->optionNumber = 2;
            $this->titulo = 'Consulta por una Fecha | Todos los Departamentos | Todos los Empleados';
            $this->selectedPorDia($array['fechaInicio']);
        }

        if (array_key_exists('consultaPor', $array))
        {
            switch ($array['consultaPor']) {
                case 'departamento':
                    if (array_key_exists('fechaFin', $array) && !array_key_exists('consultaHoy', $array))
                    {
                        $this->selectedPorDepartamentoYRango($array['fechaInicio'], $array['fechaFin'], $array['departamento'],$array['empleadoDepartamento']);
                    }
                    if (array_key_exists('consultaHoy', $array))
                    {
                        $this->selectedPorDepartamentoYDia($array['fechaInicio'], $array['departamento'],$array['empleadoDepartamento']);
                    }
                    break;

                case 'cedula':
                    if (array_key_exists('fechaFin', $array) && !array_key_exists('consultaHoy', $array))
                    {
                        $this->optionNumber = 7;
                        $this->titulo = 'Consulta por Rango de Fecha | Por Cedula de un Empleados';
                        $this->selectedPorCedulaYRango($array['fechaInicio'], $array['fechaFin'], $array['cedula']);
                    }
                    if (array_key_exists('consultaHoy', $array))
                    {
                        $this->optionNumber = 8;
                        $this->titulo = 'Consulta por una Fecha | Por Cedula de un Empleados';
                        $this->selectedPorCedulaYDia($array['fechaInicio'], $array['cedula']);
                    }
                    break;
            }

        }
    }

    private function getRegistrosPorDia($cedula, $fecha)
    {
        $records = DB::connection('ra')->table('DeviceLogRegister')->where('EnrollId','=',$cedula)->whereRaw('CAST(PunchTime AS date) = CAST(? AS date)',[date('Y-m-d',strtotime($fecha))])->get();
        return $records->isNotEmpty() ? $records->toArray() : null;
    }

    private function getNombreEmpleadoCompleto($empleado)
    {
        return $empleado->primer_nombre . ' ' . $empleado->primer_apellido;
    }

    private function getRegistrosPorRango($cedula, $fecha1, $fecha2)
    {
        $records = DB::connection('ra')->table('DeviceLogRegister')->where('EnrollId','=',$cedula)->whereRaw('CAST(PunchTime AS date) >= CAST(? AS date) AND CAST(PunchTime AS date) <= CAST(? AS date)',[date('Y-m-d',strtotime($fecha1)), date('Y-m-d',strtotime($fecha2))])->get();
        return $records->isNotEmpty() ? $records->toArray() : null;
    }

    private function getDepartamentos(){
        return DB::connection('merulink')->table('Departamentos')->select('codigo','nombre')->where('codigo', '>', 0)->get();
    }

    private function getDepartamento($departamentoId)
    {
        return DB::connection('merulink')->table('Departamentos')->select('codigo','nombre')->where('codigo', '=', $departamentoId)->first();
    }

    private function tieneSubdepartamento($departamentoId)
    {
        return DB::connection('merulink')->table('sub_departamentos')->where('Departamento_id', '=', $departamentoId)->exists();
    }

    private function hayEmpleadosEnSubdepartamento($subdepartamentoId)
    {
        return DB::connection('merulink')->table('Empleados')->where('SubDepartamento_id', '=', $subdepartamentoId)->exists();
    }


    private function getSubdepartamentos($departamentoId)
    {
        return DB::connection('merulink')->table('sub_departamentos')->select('codigo','nombre')->where('Departamento_id', '=', $departamentoId)->get();
    }

    private function getEmpleadosPorDepartamento($departamentoId)
    {
        return DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre', 'primer_apellido','SubDepartamento_id')->where('Departamento_id', '=', $departamentoId)->where('inactivo','=',false)->get();
    }

    private function getEmpleadosPorSubdepartamento($subdepartamentoId)
    {
        return DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre', 'primer_apellido','SubDepartamento_id')->where('SubDepartamento_id', '=', $subdepartamentoId)->where('inactivo','=',false)->get();
    }


    private function getEmpleadoPorDepartamento($cedula, $id)
    {
        return DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre', 'primer_apellido')->where('cedula', '=', $cedula)->where('Departamento_id', '=', $id)->where('inactivo','=',false)->first();
    }
    private function getEmpleadoPorCedula($cedula)
    {
        return DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre', 'primer_apellido','Departamento_id')->where('cedula', '=', $cedula)->where('inactivo','=',false)->first();
    }


    public function render()
    {

        return view('livewire.resultado-auditoria-asistencia', ['titulo'=>$this->titulo])
        ->extends('asistencia.auditoria')
        ->section('body-content');
    }
}
