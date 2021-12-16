@extends('layouts.app')

@section('content')
    <div class="row justify-content-center "> 
         <div class="ui segment">
             @livewire('barrido-datos-punch-data')
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        @livewire('saludo-inicio')
    </div>

@endsection