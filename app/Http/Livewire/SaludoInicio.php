<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class SaludoInicio extends Component
{
    public function render()
    {
        $nombre = Str::upper(session()->get('nombre_completo'));

        return view('livewire.saludo-inicio',compact('nombre'));
    }
}
