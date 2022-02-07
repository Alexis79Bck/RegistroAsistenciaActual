<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MenuTopBar extends Component
{
    public function render()
    {

        return view('livewire.menu-top-bar');
    }
}
