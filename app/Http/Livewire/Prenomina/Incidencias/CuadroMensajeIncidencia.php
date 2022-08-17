<?php

namespace App\Http\Livewire\Prenomina\Incidencias;

use Livewire\Component;
use App\Models\Incidencia;
use Illuminate\Support\Facades\DB;
use Facade\Ignition\Context\LivewireRequestContext;

class CuadroMensajeIncidencia extends Component
{
    public $cedula;
    public $fecha;
    public $mensaje;
    public $resultado;
    public $observacion;

    public $checkGuardar = false;

    public function mount($data, $fecha, $cedula) {

        $this->fecha = $fecha;
        $this->cedula = $cedula;
        $this->resultado = [
                "Mensaje" => $data['Mensaje'],
                "MensajeEntrada" => $data['MensajeEntrada'],
                "MensajeSalida" => $data['MensajeSalida'],
                "ColorIncidencia" => $data['ColorIncidencia'],
                "HayIncidencia" => $data['HayIncidencia'],
        ];
        $this->mensaje = ($data['Mensaje'] != "" ? $data['Mensaje'] . ' - ' : "")
            . ($data['MensajeEntrada'] != "" ? $data['MensajeEntrada'] . ' - ' : "")
            . ($data['MensajeSalida'] != "" ? $data['MensajeSalida'] . ' - ' : "");

    }


    public function Guardar() {

        $incidencia = new Incidencia;
        $incidencia->fecha = $this->fecha;
        $incidencia->cedula_empleado = $this->cedula;
        $incidencia->mensaje = $this->mensaje;
        $incidencia->observacion = $this->observacion;
        $incidencia->save();

        $this->checkGuardar = true;
    }

    public function render()
    {
        return view('livewire.prenomina.incidencias.cuadro-mensaje-incidencia');
    }
}
