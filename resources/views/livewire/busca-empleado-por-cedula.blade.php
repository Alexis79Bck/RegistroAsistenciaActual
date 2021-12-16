<div>
    <div class="form-check">
        <input class="form-check-input busqueda" type="radio" name="busqueda" id="opCedula" value="cedula" checked>
        {!! Form::label('opCedula', 'Cédula:', ['class'=>'form-check-label']) !!}                
    </div>
    <div class="input-group input-group-sm" id="grupoCedula">    
        {!! Form::text('cedula', null, ['id'=>'cedula', 'class'=>'form-control', 'onKeyPress'=>'return soloNumeros(event)','maxlength'=>'9','wire:model'=>'cedula']) !!}
        
        <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorCedula" wire:click="buscaEmpleado" ><i class="fas fa-search text-light"></i></a> 
    </div>   
    
</div>
