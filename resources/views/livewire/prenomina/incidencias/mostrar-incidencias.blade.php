
<div class="row justify-content-end">
    <div class="col ">
        @if ($nivel == 1)
        {!! Form::label('Departamento', 'Departamento:', ['class' => 'form-check-label']) !!}

        <select name="departamento" class="form-select form-select-sm"  wire:model="selectedDepartamento">
            <option>-- Seleccione --</option>
            @foreach ($departamentos as $depto)
            <option value="{{$depto->codigo}}">{{ $depto->nombre }}</option>
            @endforeach

        </select>
        @else

        {!! Form::label('Departamento', 'Departamento:', ['class' => 'form-check-label']) !!}
        <div class="h4">{{ session('nombre_departamento') }}</div>
        {!! Form::hidden('departamento', session('id_departamento'),['wire:model'=>'selectedDepartamento']) !!}

        @endif

        {{-- @livewire('prenomina.incidencias.select-departamento') --}}

    </div>


    <div class="col ">
        {!! Form::label('fechaInicio', 'Rango de Fecha:', ['class' => 'form-check-label']) !!}

        <div class=" form-group">

            <div class="input-group input-group-sm mb-1 " id="grupoFechaInicio">
                <span class="input-group-text bg-primary text-white fw-bold">Desde:</span>
                {!! Form::date('fechaInicio', date('Y-m-d', strtotime($fecha)), [
                'class' => 'form-control ',
                'id' => 'ctrlFechaInicio',
                'min' => date('Y-m-d', strtotime($minFecha)),
                'max' => date('Y-m-d', strtotime($maxFecha)),
                'wire:model'=>'selectedFechaIni'
                ]) !!}

            </div>

        </div>
        <div class=" form-group">
            <div class="input-group input-group-sm mb-1 " id="grupoFechaFin">
                <span class="input-group-text bg-primary text-white fw-bold">Hasta:</span>
                {!! Form::date('fechaFin', date('Y-m-d', strtotime($fecha)), [
                'class' => 'form-control',
                'id' => 'ctrlFechaFin',
                'min' => date('Y-m-d', strtotime($selectedFechaIni)),
                'max' => date('Y-m-d', strtotime($maxFecha)),
                'wire:model'=>'selectedFechaFin'
                ]) !!}
            </div>

        </div>

        {{-- @livewire('prenomina.incidencias.select-fecha-inicio')
        @livewire('prenomina.incidencias.select-fecha-fin') --}}


    </div>

    <div class="col align-self-center">
        <button class="btn btn-success text-center" type="button" wire:click="mostrarResultado()">Mostrar</button>
        {{-- @livewire('prenomina.incidencias.boton-consultar-incidencias') --}}

    </div>
</div>

