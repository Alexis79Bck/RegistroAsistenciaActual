<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonTimeZone;

class SeleccioneDia extends Component
{
    public $fecha;    

    public function lafecha() {

        $fecha = new Carbon($this->fecha);
        $this->emit('lafecha2',  $fecha);
    }
    
    public function render()
    {
        
        return view('livewire.seleccione-dia');
    }
}
