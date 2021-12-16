<div>
    {!! Form::label('selEmpleados', 'Empleados:', ['class'=>'form-label']) !!} 
    <div class="input-group input-group-sm"  > 
        
        <select name="empleados" id="selEmpleados" class="form-select form-select-sm">
        </select>             
        {{-- {!! Form::select('selEmpleados', null, null,['class'=>'form-select']) !!} --}}
        {!! Form::hidden('empleadoSeleccion', null, ['wire:model'=>'cedula','selected'=>'("cedula")']) !!}
        <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorSeleccion"><i class="fas fa-search text-light"></i></a>
    </div>
</div>
