@extends('layouts.app')

@section('content')
@if (session()->get('rol_usuario') == 'Super-Admin' || session()->get('rol_usuario') == 'Recursos Humanos')
<div class="row justify-content-center ">
    <div class="ui segment">
        @livewire('barrido-datos-punch-data')
    </div>
</div>

@endif
<div class="row justify-content-center mt-5">
    @livewire('saludo-inicio')
</div>

@endsection
