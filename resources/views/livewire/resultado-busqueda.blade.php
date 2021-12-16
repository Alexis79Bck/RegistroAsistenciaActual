
    <div class="card text-center w-50 border-primary shadow" >
        <div class="card-body">
        <p class="card-title h4 fs-3 fw-bold " id="titulo"></p> {{-- $empleado[0]->primer_nombre}} {{ $empleado[0]->primer_apellido }} - {{$empleado[0]->cedula}} --}}
        <p class="card-subtitle h5 fs-6 fst-italic  text-secondary" id="subtitulo"></p><br>{{-- $departamento[0]->nombre --}}
        <p class="card-text" id="botonesRegistro">
            <div class="row">
                <div class="col">
                    {!! Form::open(['route'=>'guardar_asistencia','method'=>'POST']) !!}
                    <input type="hidden" name="nombre" id="hnombre" > <input type="hidden" name="apellido" id="hapellido"><input type="hidden" name="cedula" id="hcedula" >
                    <input type="hidden" name="departamento" id="hdepartamento"><input type="hidden" name="cargo" id="hcargo">
                    <button class="btn btn-sm btn-success" type="submit"  id="botonMarcaEntrada">Entrada</button>        
                    {!! Form::close() !!}
                </div>

                <div class="col">
                    {!! Form::open(['route'=>'actualizar_asistencia','method'=>'POST']) !!}
                    <input type="hidden" name="nombre" id="hhnombre" > <input type="hidden" name="apellido" id="hhapellido"><input type="hidden" name="cedula" id="hhcedula" >
                    <input type="hidden" name="departamento" id="hhdepartamento"><input type="hidden" name="cargo" id="hhcargo">
                        <button class="btn btn-sm btn-danger" type="submit"  id="botonMarcaSalida">Salida</button>        
                    {!! Form::close() !!}
                </div>
 
                <div class="col">            
                    <a href="#" class="btn btn-sm btn-info" id="botonMarcaEditar" data-bs-toggle="modal" data-bs-target="#modalEditarAsistencia">Editar</a>        
                     {!! Form::open(['route'=>'editar_asistencia','method'=>'POST','id'=>'formEditarAsistencia']) !!} 
                    <input type="hidden" name="nombre" id="hgnombre" > <input type="hidden" name="apellido" id="hgapellido"><input type="hidden" name="cedula" id="hgcedula" >
                    <input type="hidden" name="departamento" id="hgdepartamento"><input type="hidden" name="cargo" id="hgcargo">
                    <div class="modal fade" id="modalEditarAsistencia" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalEditarAsistenciaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"> 
                            <h5 class="modal-title" id="exampleModalLabel">Editar Asistencia ({{ date('d/m/Y') }})</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group mb-1">
                                                <label class="input-group-text bg-primary text-white">Entrada:</label>
                                                <select class="form-select" class="border border-warning" name="editarHoraEntrada" id="editarHoraEntrada">
                                                  @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                  @endfor  
                                                </select>
                                                <select class="form-select" name="editarMinEntrada" id="editarMinEntrada" >
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i <10)
                                                            <option value="0{{$i}}">0{{$i}}</option>      
                                                        @else
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endif
                                                    @endfor  
                                                </select>
                                                <select class="form-select" name="editarMdEntrada" id="editarMdEntrada">
                                            
                                                    <option value="am">a.m.</option>                                                 
                                                    <option value="pm">p.m.</option>
                                                       
                                                </select>
                                                
                                            </div>
                                        </div>
                                       
                                        <div class="col" id="grupoColSalida">
                                            <div class="input-group  mb-1"  >
                                                <label class="input-group-text bg-primary text-white" id="labelHoraSalida" >Salida:</label>
                                                
                                                <select class="form-select" name="editarHoraSalida" id="editarHoraSalida">
                                                  @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                  @endfor  
                                                </select>

                                                <select class="form-select" name="editarMinSalida" id="editarMinSalida">
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i <10)
                                                            <option value="0{{$i}}">0{{$i}}</option>      
                                                        @else
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endif
                                                    @endfor  
                                                </select>
                                                <select class="form-select" name="editarMdSalida" id="editarMdSalida">
                                            
                                                    <option value="am">a.m.</option>                                                 
                                                    <option value="pm">p.m.</option>
                                                       
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                     
                                    <div class="row" id="segundaFila">
                                        <div class="col" id="grupoColEntrada2">
                                            <div class="input-group mb-1">
                                                <label class="input-group-text bg-primary text-white">Entrada:</label>
                                                <select class="form-select" class="border border-warning" name="editarHoraEntrada2" id="editarHoraEntrada2">
                                                  @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                  @endfor  
                                                </select>
                                                <select class="form-select" name="editarMinEntrada2" id="editarMinEntrada2" >
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i <10)
                                                            <option value="0{{$i}}">0{{$i}}</option>      
                                                        @else
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endif
                                                    @endfor  
                                                </select>
                                                <select class="form-select" name="editarMdEntrada2" id="editarMdEntrada2">
                                            
                                                    <option value="am">a.m.</option>                                                 
                                                    <option value="pm">p.m.</option>
                                                       
                                                </select>
                                                
                                            </div>
                                        </div>
                                       
                                        <div class="col" id="grupoColSalida2">
                                            <div class="input-group  mb-1"  >
                                                <label class="input-group-text bg-primary text-white" id="labelHoraSalida2" >Salida:</label>
                                                
                                                <select class="form-select" name="editarHoraSalida2" id="editarHoraSalida2">
                                                  @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                  @endfor  
                                                </select>

                                                <select class="form-select" name="editarMinSalida2" id="editarMinSalida2">
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i <10)
                                                            <option value="0{{$i}}">0{{$i}}</option>      
                                                        @else
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endif
                                                    @endfor  
                                                </select>
                                                <select class="form-select" name="editarMdSalida2" id="editarMdSalida2">
                                            
                                                    <option value="am">a.m.</option>                                                 
                                                    <option value="pm">p.m.</option>
                                                       
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row w-100 justify-content-center" id="filaMensaje">

                                    </div>
                                </div>                                
                            </div>
                            <div class="modal-footer" >
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-success" id="botonGuardarEditar">Guardar</button>
                            </div>
                        </div>
                        </div>
                    </div>
                     {!! Form::close() !!} 
                  
                </div>

            </div>
            {{-- <a href=" {{ route('guardar_asistencia') }}" class="btn btn-sm btn-success" role="button"  id="botonMarcaEntrada">Entrada</a> - <a href=" {{ route('actualizar_asistencia') }}" role="button" class="btn btn-sm btn-danger" id="botonMarcaSalida">Salida</i></a> -  <button class="btn btn-sm btn-info" id="botonIngresoManual" disabled style="cursor:not-allowed;">Manual</i></button> --}}
        </p>
        
        </div>
    </div>

