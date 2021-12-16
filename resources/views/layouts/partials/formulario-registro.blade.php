<div class="row justify-content-center pt-3 m-5" id="busquedaEmpleado">
    <div class="modal fade" id="registroAsistencia" tabindex="-1" role="dialog" aria-labelledby="registroAsistencia" aria-hidden="true">
      {!! Form::open(['action' => 'AsistenciaController@store', 'method' => 'POST']) !!} 
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card text-center w-50" >
              <div class="card-body">
                <p class="card-title h5 fs-3 fw-bold ">{{ $empleado[0]->primer_nombre}} {{ $empleado[0]->primer_apellido }} - {{$empleado[0]->cedula}}</p>
                <p class="card-subtitle h6 fs-5 fst-italic  text-secondary">{{$departamento[0]->nombre}}</p><br>
                
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-success">Entrada</button>   
            <button class="btn btn-sm btn-danger">Salida</i></button>
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button> --}}
          </div>
        </div>
      </div>
      {!! Form::close() !!} 
    </div>

{{-- 
  @if ($empleado != null && $departamento != null)
  <div class="card text-center w-50" >
      <div class="card-body">
        <p class="card-title h4 fs-3 fw-bold ">{{ $empleado[0]->primer_nombre}} {{ $empleado[0]->primer_apellido }} - {{$empleado[0]->cedula}}</p>
        <p class="card-subtitle h5 fs-6 fst-italic  text-secondary">{{$departamento[0]->nombre}}</p><br>
        <p class="card-text"><button class="btn btn-sm btn-success">Entrada</button>   -   <button class="btn btn-sm btn-danger">Salida</i></button></p>
      </div>
    </div>
  @else
    {{ 'Por aca paso por nulo '}}    
  @endif
   --}}
   
</div>
