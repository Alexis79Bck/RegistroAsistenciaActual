<div class="row justify-content-end">
    <div class="col ">

        {!! Form::label('Departamento', 'Departamento:', ['class' => 'form-check-label']) !!}

        <select name="departamento" class="form-select form-select-sm" wire:model="selectedDepartamento">
            <option>-- Seleccione --</option>
            @foreach ($departamentos as $depto)
            <option value="{{$depto->codigo}}">{{ $depto->nombre }}</option>
            @endforeach

        </select> 
    </div>




    <div class="col align-self-center">
        <button class="btn btn-success text-center" type="button" wire:click="mostrarResumen()">Mostrar</button>


    </div>
</div>
