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
                    
                    <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorCedula" wire:click="buscaCedulaEmpleado" ><i class="fas fa-search text-light"></i></a> 
                </div>
                
                {{-- @livewire('busca-empleado-por-cedula') --}}
                
                

            </div>
        </div>

        <div class="col w-25">
            <div class=" form-group" id="grupoDepartamento">
                <div class="form-check">
                    <input class="form-check-input busqueda" type="radio" name="busqueda" id="opDepartamento" value="departamento">
                    {!! Form::label('opDepartamento', 'Departamento:', ['class'=>'form-check-label']) !!}               
                </div>
                <select name="departamento" id="selDepartamento" class="form-select form-select-sm">
                    <option >-- Seleccione --</option>
                    @foreach ($departamentos as $item)
                        <option value="{{ $item->codigo }}">{{$item->nombre}}</option>
                    @endforeach
                </select>
                
            </div>  
            {{-- {!! Form::select('departamento', $departamentos->nombre, null,['class'=>'form-select','id'=>'selDepartamento']) !!} --}}
            
        </div>

        <div class="col w-25" id="grupoEmpleados">
            <span id="mensajeTexto"></span> 
            <div class=" form-group" id="divEmpleados">
                {!! Form::label('selEmpleados', 'Empleados:', ['class'=>'form-label']) !!} 
                <div class="input-group input-group-sm"  > 
                    
                    <select name="empleados" id="selEmpleados" class="form-select form-select-sm" wire:model="selEmpleados" selected="('selEmpleados')" wire:click="buscaSeleccionEmpleado">
                    </select>             
                    {{-- <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorSeleccion" ><i class="fas fa-search text-light"></i></a> --}}
                </div>
                {{-- {!! Form::label('selEmpleados', 'Empleados:', ['class'=>'form-label']) !!}  --}}
                {{-- @livewire('busca-empleado-por-seleccion') --}}

            </div>

        </div>

    </div>
    
    <div class="row justify-content-center pt-3 m-5" id="busquedaEmpleado">

        <div class="card text-center w-50" >
            <div class="card-body">
            <p class="card-title h4 fs-3 fw-bold " id="titulo"> {{$nombre}} {{ $apellido }} - {{$cedula}}</p> {{-- $empleado[0]->primer_nombre}} {{ $empleado[0]->primer_apellido }} - {{$empleado[0]->cedula}} --}}
            <p class="card-subtitle h5 fs-6 fst-italic  text-secondary" id="subtitulo">{{$departamento}} / {{$cargo}} </p><br>{{-- $departamento[0]->nombre --}}
            <p class="card-text" id="botonesRegistro"><button href="#" class="btn btn-sm btn-success" type="submit" id="botonMarcaEntrada">Entrada</button> - <button  class="btn btn-sm btn-danger" type="submit" id="botonMarcaSalida">Salida</i></button> -  <button class="btn btn-sm btn-info" id="botonIngresoManual" disabled style="cursor:not-allowed;">Manual</i></button></p>
            </div>
        </div>
    </div>
  
{{--        @livewire('resultado-busqueda', ['data' => $data])

        <div class="card text-center w-50" >
            <div class="card-body">
            <p class="card-title h4 fs-3 fw-bold " id="titulo">{{$empleado->primer_nombre}} {{ $empleado->primer_apellido }} - {{$empleado->cedula}}</p> {{-- $empleado[0]->primer_nombre}} {{ $empleado[0]->primer_apellido }} - {{$empleado[0]->cedula}} -}}
            <p class="card-subtitle h5 fs-6 fst-italic  text-secondary" id="subtitulo">{{$departamento->nombre}} / {{$cargo->nombre}} </p><br>{{-- $departamento[0]->nombre -}}
            <p class="card-text" id="botonesRegistro">
                {!! Form::open(['route' => 'guardar_asistencia', 'method' => 'POST']) !!}  
                <button href="#" class="btn btn-sm btn-success" type="submit" id="botonMarcaEntrada">Entrada</button>
                {!! Form::close() !!}
                -
                {!! Form::open(['route' => ['actualizar_asistencia',], 'method' => 'POST']) !!}  
                    <button  class="btn btn-sm btn-danger" type="submit" id="botonMarcaSalida">Salida</i></button> 
                {!! Form::close() !!}
                -  <button class="btn btn-sm btn-info" id="botonIngresoManual" disabled style="cursor:not-allowed;">Manual</i></button></p>
            </div>
        </div>
     --}}

</div>