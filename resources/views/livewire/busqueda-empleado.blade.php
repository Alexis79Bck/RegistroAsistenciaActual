<div>
<div class="row row-cols-3 ">
    <div class="col w-25">
        <div class=" form-group">
            <div class="form-check">
                <input class="form-check-input busqueda" type="radio" name="busqueda" id="opCedula" value="cedula" checked>
                {!! Form::label('opCedula', 'Cédula:', ['class'=>'form-check-label']) !!}                
            </div>

            <div class="input-group input-group-sm" id="grupoCedula">    
                {!! Form::text('cedula', null, ['id'=>'cedula', 'class'=>'form-control', 'onKeyPress'=>'return soloNumeros(event)','maxlength'=>'9','wire:model'=>'cedula']) !!}
                
                <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorCedula" wire:click="buscaPorCedula" ><i class="fas fa-search text-light"></i></a> 
            </div>

            
        </div>
    </div>

    <div class="col w-25">
        <div class=" form-group" id="grupoDepartamento">
            <div class="form-check">
                <input class="form-check-input busqueda" type="radio" name="busqueda" id="opDepartamento" value="departamento">
                {!! Form::label('opDepartamento', 'Departamento:', ['class'=>'form-check-label']) !!}               
            </div>
            <select name="departamento" id="selDepartamento" class="form-select form-select-sm">
                @foreach ($departamentos as $item)
                    <option value="{{ $item->codigo }}">{{$item->nombre}}</li>
                @endforeach

            </select>
            
            {{-- {!! Form::select('departamento', $departamentos->nombre, null,['class'=>'form-select','id'=>'selDepartamento']) !!} --}}
            
            
        </div>
    </div>

    <div class="col w-25" id="grupoEmpleados">
        <span id="mensajeTexto"></span> 
        <div class=" form-group" id="divEmpleados">
            
            {!! Form::label('selEmpleados', 'Empleados:', ['class'=>'form-label']) !!} 
            <div class="input-group input-group-sm"  > 
                
                <select name="empleados" id="selEmpleados" class="form-select form-select-sm">
                </select>             
                {{-- {!! Form::select('selEmpleados', null, null,['class'=>'form-select']) !!} --}}
                <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorDepartamento"><i class="fas fa-search text-light"></i></a>
            </div>
        </div>

    </div>
     
</div> 
{{session('empleado')}}
{!! Form::open(['action' => 'AsistenciaController@store', 'method' => 'POST']) !!}  
     @livewire('formulario-registro',['empleado' => $empleado, 'departamento'=>$departamento])
  {!! Form::close() !!}    
</div> 

