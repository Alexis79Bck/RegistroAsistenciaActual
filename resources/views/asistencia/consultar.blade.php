@extends('layouts.app')

@section('content')
  <div class="row row-cols-3 align-items-center mt-2 ">
    <div class="col  ">
      <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png')}}" width="33%" height="50%">
    </div>
    <div class="col ">
      <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Consultar Asistencia</div>
    </div>
    <div class="col">
      <p></p>
    </div>
  </div>
  <div class="row row-cols-3 mb-3">
    <div class="col  ">
      <p></p>
    </div>
    <div class="col ">
      <div class="fs-4 fw-bold text-center " style="color: #014a97;" id="reloj"></div>
    </div>
    <div class="col">
      <p></p>
    </div>
  </div>
  <div class="row justify-content-end">
    <div class="col">
      @include('layouts.partials.mensajes')
    </div>
  </div>
  
  <hr class="dropdown-divider">
  
  {!! Form::open(['route'=>'ejecutar_consulta','class'=>'g-1 align-items-center','id'=>'formConsultar']) !!}
  <div class="row mb-2">
    <div class="col w-25">
      {!! Form::label('fechaInicio', 'Rango de Fecha:', ['class'=>'form-check-label']) !!}                
    </div>
    
    <div class="col">
     
      <div class=" form-group">        
        <div class="input-group input-group-sm mb-1 " id="grupoFechaInicio"> 
          <span class="input-group-text bg-primary text-white fw-bold" >Desde:</span>
          {!! Form::date('fechaInicio', date('Y-m-d'), ['class'=>'form-control ', 'id' => 'ctrlFechaInicio', 'min'=>  date('Y-m-d', strtotime($minFijadoFechaInicio)), 'max'=>date('Y-m-d', strtotime('today'))]) !!}   

        </div>
      </div>
    </div>
    <div class="col">
      <div class=" form-group">        
        <div class="input-group input-group-sm mb-1 " id="grupoFechaFin"> 
          <span class="input-group-text bg-primary text-white fw-bold" >Hasta:</span>
          {!! Form::date('fechaFin', date('Y-m-d'), ['class'=>'form-control', 'id' => 'ctrlFechaFin', 'min'=>date('Y-m-d', strtotime($minFijadoFechaInicio)), 'max'=>date('Y-m-d', strtotime('today'))]) !!}   
        </div>
      </div>
    </div>
    <div class="col">
       <button class="btn btn-sm btn-success" type="submit" value="consultar" ><i class="fas fa-search text-light"></i> Consultar</button>
    </div>
    
    
    <div class="row  mb-2">
      <div class="col">
        {!! Form::label('', 'Opciones de Búsqueda:', ['class'=>'form-check-label']) !!}                
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="consultaHoy" id="consultaHoy" value="hoy">
          {!! Form::label('consultaHoy', 'Del día', ['class'=>'form-check-label']) !!}                
        </div>        
      </div>
      <div class="col">
        <div class="form-check">
          {!! Form::radio('consultaPor', 'departamento', false, ['id'=>'consultaPorDepartamento','class'=>'form-check-input']) !!}
          {{-- <input class="form-check-input" type="radio" name="consultaPor" id="consultaPorDepartamento" value="departamento"> --}}
          {!! Form::label('consultaPorDepartamento', 'Por Departamento', ['class'=>'form-check-label']) !!}                
        </div>
        <div class=" form-group" id="grupoDepartamentos">
          <select name="departamento" id="selDepartamento" class="form-select form-select-sm"></select>
        </div>  
        <div class=" form-group" id="grupoEmpleadosDepartamento">
          <select name="empleadoDepartamento" id="selEmpleadoDepartamento" class="form-select form-select-sm"></select>
        </div>        
      </div>
      <div class="col">
        <div class="form-check">
          {!! Form::radio('consultaPor', 'cedula', false, ['id'=>'consultaPorCedula','class'=>'form-check-input']) !!}
          {{-- <input class="form-check-input" type="radio" name="consultaPor" id="consultaPorCedula" value="cedula"> --}}
          {!! Form::label('consultaPorCedula', 'Por Cédula', ['class'=>'form-check-label']) !!}                
        </div>
        {!! Form::text('cedula', null, ['id'=>'cedula', 'class'=>'form-control form-control-sm', 'onKeyPress'=>'return soloNumeros(event)','maxlength'=>'9']) !!}        
      </div>
    </div>
    
    
  </div>
  {!! Form::close() !!}
  <hr class="dropdown-divider">
  <div class="row  justify-content-md-center">
    <div class="col"> 
      <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Resultado de la Consulta</div>
    </div>
    <div class="col-md-auto">
      @if ($info != null)
       
        <a class="btn btn-outline-danger" href="{{ route ('impReporte')}}" target="_blank" type="button" form="formConsultar"><i class="fs-4 far fa-file-pdf fa-lg"></i></i></a>
          
      @endif
      
    </div>

    
  </div>

  <div class="row justify-content-center  mb-4" id="resultadoBusqueda">
    @switch($tipoReporte)
        @case(1)
        @if ($ctData > 0)
        @for ($i = 0; $i < $ctDepartamento; $i++)  
        @if ($ctReg[$i] == 1)            
          <table class=" shadow table table-bordered border-dark">
              <tr class="bg-primary text-light  fw-bold text-center">
                
                  <td colspan="7">
                    <span class="fs-4"> {{ $departamento[$i]->nombre}} </span>
                  </td>
                
              </tr>
              <tr class="bg-primary text-light fs-6 fw-bold text-center">
                <td>Fecha</td>
                <td>Nombre y Apellido</td>
                <td>Cédula</td>
                
                <td>Hora Entrada</td>
                <td>Hora Salida</td>
                <td>Modo Entrada</td>
                <td >Total Horas</td> 
              </tr> 
                @for ($j = 0; $j < $ctData; $j++) 
                 @if ($departamento[$i]->nombre == $info[$i][$j]['departamento']) 
                 @for ($k = 0; $k <= $ctFecha; $k++)
                     
                    @if ($lstFecha[$k] == $info[$i][$j]['fecha'])
                        
                    
                        <tr>
                          <td data-label="Fecha">{{$info[$i][$j]['fecha']}}</td>
                          <td data-label="Nombre y Apellido">{{$info[$i][$j]['nombre']}}</td>
                          <td data-label="Cédula">{{$info[$i][$j]['cedula']}}</td>
                          
                          <td data-label="Hora Entrada">
                            @if ($info[$i][$j]['horaEnt'] == null)
                                <span class="text-danger">Empleado no registró entrada</span>
                            @else
                                {{$info[$i][$j]['horaEnt']}}
                            @endif
                            @if ($info[$i][$j]['horaEnt2'] != null)
                                <br> 
                                {{$info[$i][$j]['horaEnt2']}}
                            @endif
                          </td>
    
                          <td data-label="Hora Salida">
                            @if ($info[$i][$j]['horaSal'] == null)
                                <span class="text-danger">Empleado no registró salida</span>
                            @else
                                {{$info[$i][$j]['horaSal']}}
                            @endif
                            @if ($info[$i][$j]['horaEnt2'] != null)
                                @if ($info[$i][$j]['horaSal2'] == null)
                                    <br>
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    <br>
                                    {{$info[$i][$j]['horaSal2']}}
                                @endif
                            @endif
                            
                          </td>
    
                          <td data-label="Modo Entrada">
                            
                                <span class="text-danger">{{$info[$i][$j]['Modo']}}</span>
                            
                          </td>
                          <td data-label="Total Horas">
                            @if ($info[$i][$j]['horaSal'] == null)
                                <span class="text-danger">Calculo no disponible</span>
                            @else
                                {{$info[$i][$j]['totalHoras']}}
                            @endif
                            
                          </td>
                        </tr>                             
                        @endif
                        @endfor
                    @endif 
                   
                         
                @endfor
                @endif
                            
          </table> 
                
        @endfor  
        @else
        <table class=" shadow table table-bordered border-dark ">
          <tr class="bg-primary text-light  fw-bold text-center">
                  
            <td colspan="7">
              <span class="fs-4">   </span>
            </td>
          
          </tr>
          <tr class="bg-primary text-light fs-6 fw-bold text-center">
            <td>Fecha</td>
            <td>Nombre y Apellido</td>
            <td>Cédula</td>
            
            <td >Hora Entrada</td>
            <td>Hora Salida</td>
            <td>Modo Entrada</td>
            <td >Total Horas</td> 
          </tr>
          <tr class=" text-secondary  fw-bold text-center">
        
              <td colspan="7">
                <span class="fs-4"> No hay información disponible </span>
              </td>
            
          </tr> 
        </table>
        @endif

            @break
        @case(2)
         @if ($ctData > 0)
          @for ($i = 0; $i < $ctDepartamento; $i++)
          

            <table class=" shadow table table-bordered border-dark ">
                <tr class="bg-primary text-light  fw-bold text-center">
                  
                    <td colspan="7">
                      <span class="fs-4"> {{ $departamento[$i]->nombre}} </span>
                    </td>
                  
                </tr>
                <tr >
                  <td>Fecha</td>
                  <td>Nombre y Apellido</td>
                  <td>Cédula</td>
                  
                  <td >Hora Entrada</td>
                  <td>Hora Salida</td>
                  <td>Modo Entrada</td>
                  <td >Total Horas</td> 
                </tr>
                @if ($ctReg[$i] == 0)
                  <tr class=" text-secondary  fw-bold text-center">
                
                      <td colspan="7">
                        <span class="fs-4"> No hay información disponible </span>
                      </td>
                    
                  </tr> 
                @else
                  @for ($j = 0; $j < $ctData; $j++)
                  @if ($departamento[$i]->nombre == $info[$i][$j]['departamento']) 
                      <tr>
                        <td data-label="Fecha">{{$info[$i][$j]['fecha']}}</td>
                        <td data-label="Nombre y Apellido">{{$info[$i][$j]['nombre']}}</td>
                        <td data-label="Cédula">{{$info[$i][$j]['cedula']}}</td>
                        
                        <td data-label="Hora Entrada">
                          @if ($info[$i][$j]['horaEnt'] == null)
                              <span class="text-danger">Empleado no registró entrada</span>
                          @else
                              {{$info[$i][$j]['horaEnt']}}
                          @endif
                          @if ($info[$i][$j]['horaEnt2'] != null)
                                <br> 
                                {{$info[$i][$j]['horaEnt2']}}
                            @endif
                        </td>
                        <td data-label="Hora Salida">
                          @if ($info[$i][$j]['horaSal'] == null)
                              <span class="text-danger">Empleado no registró salida</span>
                          @else
                              {{$info[$i][$j]['horaSal']}}
                          @endif
                          @if ($info[$i][$j]['horaEnt2'] != null)
                                @if ($info[$i][$j]['horaSal2'] == null)
                                    <br>
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    <br>
                                    {{$info[$i][$j]['horaSal2']}}
                                @endif
                            @endif
                        </td>
                        <td data-label="Modo Entrada">
                          
                              <span class="text-danger">{{$info[$i][$j]['Modo']}}</span>
                          
                        </td>
                        <td data-label="Total Horas">
                          @if ($info[$i][$j]['horaSal'] == null)
                              <span class="text-danger">Calculo no disponible</span>
                          @else
                              {{$info[$i][$j]['totalHoras']}}
                          @endif
                          
                        </td>
                      </tr>   
                      @endif      
                  @endfor
                   @endif              
            </table> 
               
          @endfor  
          @else
          <table class=" shadow table table-bordered border-dark ">
            <tr class="bg-primary text-light  fw-bold text-center">
                    
              <td colspan="7">
                <span class="fs-4">   </span>
              </td>
            
            </tr>
            <tr class="bg-primary text-light fs-6 fw-bold text-center">
              <td>Fecha</td>
              <td>Nombre y Apellido</td>
              <td>Cédula</td>
              
              <td >Hora Entrada</td>
              <td>Hora Salida</td>
              <td>Modo Entrada</td>
              <td >Total Horas</td> 
            </tr>
            <tr class=" text-secondary  fw-bold text-center">
          
                <td colspan="7">
                  <span class="fs-4"> No hay información disponible </span>
                </td>
              
            </tr> 
          </table>
          @endif
          @break

          @case(3)
          <table class=" shadow table table-bordered border-dark ">
            <tr class="bg-primary text-light  fw-bold text-center">
              
                <td colspan="7">
                  <span class="fs-4"> {{ $departamento[0]}} </span>
                </td>
              
            </tr>
            <tr >
              <td>Fecha</td>
              <td>Nombre y Apellido</td>
              <td>Cédula</td>
              
              <td >Hora Entrada</td>
              <td>Hora Salida</td>
              <td>Modo Entrada</td>
              <td >Total Horas</td> 
            </tr>
            @if ($ctData == 0)
                  <tr class=" text-secondary  fw-bold text-center">
                
                      <td colspan="7">
                        <span class="fs-4"> No hay información disponible </span>
                      </td>
                    
                  </tr> 
            @else
                @for ($j = 0; $j < $ctData; $j++)
                  @for ($k = 0; $k <= $ctFecha; $k++)
                      
                  @if ($lstFecha[$k] == $info[$j]['fecha'])
                      <tr>
                        <td data-label="Fecha">{{$info[$j]['fecha']}}</td>
                        <td data-label="Nombre y Apellido">{{$info[$j]['nombre']}}</td>
                        <td data-label="Cédula">{{$info[$j]['cedula']}}</td>
                        
                        <td data-label="Hora Entrada">
                          @if ($info[$j]['horaEnt'] == null)
                              <span class="text-danger">Empleado no registró entrada</span>
                          @else
                              {{$info[$j]['horaEnt']}}
                          @endif
                          @if ($info[$j]['horaEnt2'] != null)
                                <br> 
                                {{$info[$j]['horaEnt2']}}
                            @endif
                        </td>
                        <td data-label="Hora Salida">
                          @if ($info[$j]['horaSal'] == null)
                              <span class="text-danger">Empleado no registró salida</span>
                          @else
                              {{$info[$j]['horaSal']}}
                          @endif
                          @if ($info[$j]['horaEnt2'] != null)
                                @if ($info[$j]['horaSal2'] == null)
                                    <br>
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    <br>
                                    {{$info[$j]['horaSal2']}}
                                @endif
                            @endif
                        </td>
                        <td data-label="Modo Entrada">
                          
                              <span class="text-danger">{{$info[$j]['Modo']}}</span>
                          
                        </td>
                        <td data-label="Total Horas">
                          @if ($info[$j]['horaSal'] == null)
                              <span class="text-danger">Calculo no disponible</span>
                          @else
                              {{$info[$j]['totalHoras']}}
                          @endif
                          
                        </td>
                      </tr>  
                      @endif
                    @endfor    
                  @endfor 
              @endif
            </table>
            @break
                      
            @case(4)
            <table class=" shadow table table-bordered border-dark ">
              <tr class="bg-primary text-light  fw-bold text-center">
                
                  <td colspan="7">
                    <span class="fs-4"> {{ $departamento[0]}} </span>
                  </td>
                
              </tr>
              <tr >
                <td>Fecha</td>
                <td>Nombre y Apellido</td>
                <td>Cédula</td>
                
                <td >Hora Entrada</td>
                <td>Hora Salida</td>
                <td>Modo Entrada</td>
                <td >Total Horas</td> 
              </tr>
              @if ($ctData == 0)
                    <tr class=" text-secondary  fw-bold text-center">
                  
                        <td colspan="7">
                          <span class="fs-4"> No hay información disponible </span>
                        </td>
                      
                    </tr> 
              @else
                  @for ($j = 0; $j < $ctData; $j++)
                        <tr>
                          <td data-label="Fecha">{{$info[$j]['fecha']}}</td>
                          <td data-label="Nombre y Apellido">{{$info[$j]['nombre']}}</td>
                          <td data-label="Cédula">{{$info[$j]['cedula']}}</td>
                          
                          <td data-label="Hora Entrada">
                            @if ($info[$j]['horaEnt'] == null)
                                <span class="text-danger">Empleado no registró entrada</span>
                            @else
                                {{$info[$j]['horaEnt']}}
                            @endif
                            @if ($info[$j]['horaEnt2'] != null)
                                <br> 
                                {{$info[$j]['horaEnt2']}}
                            @endif
                          </td>
                          <td data-label="Hora Salida">
                            @if ($info[$j]['horaSal'] == null)
                                <span class="text-danger">Empleado no registró salida</span>
                            @else
                                {{$info[$j]['horaSal']}}
                            @endif
                            @if ($info[$j]['horaEnt2'] != null)
                                @if ($info[$j]['horaSal2'] == null)
                                    <br>
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    <br>
                                    {{$info[$j]['horaSal2']}}
                                @endif
                            @endif
                          </td>
                          <td data-label="Modo Entrada">
                            
                                <span class="text-danger">{{$info[$j]['Modo']}}</span>
                            
                          </td>
                          <td data-label="Total Horas">
                            @if ($info[$j]['horaSal'] == null)
                                <span class="text-danger">Calculo no disponible</span>
                            @else
                                {{$info[$j]['totalHoras']}}
                            @endif
                            
                          </td>
                        </tr>  
                    @endfor 
                @endif
              </table>
              @break

              @case(5)
                <table class=" shadow table table-bordered border-dark ">
                  <tr class="bg-primary text-light  fw-bold text-center">
                    
                      <td colspan="7">
                        <span class="fs-4"> {{ $nombreEmpleado }}  -  {{ $departamento[0]}} </span>
                      </td>
                    
                  </tr>
                  <tr >
                    <td>Fecha</td>                    
                    <td >Hora Entrada</td>
                    <td>Hora Salida</td>
                    <td>Modo Entrada</td>
                    <td >Total Horas</td> 
                  </tr>
                  @if ($ctData == 0)
                        <tr class=" text-secondary  fw-bold text-center">
                      
                            <td colspan="7">
                              <span class="fs-4"> No hay información disponible </span>
                            </td>
                          
                        </tr> 
                  @else
                      @for ($j = 0; $j < $ctData; $j++)
                            <tr>
                              <td data-label="Fecha">{{$info[$j]['fecha']}}</td>
                              
                              <td data-label="Hora Entrada">
                                @if ($info[$j]['horaEnt'] == null)
                                    <span class="text-danger">Empleado no registró entrada</span>
                                @else
                                    {{$info[$j]['horaEnt']}}
                                @endif
                                @if ($info[$j]['horaEnt2'] != null)
                                  <br> 
                                  {{$info[$j]['horaEnt2']}}
                                @endif
                              </td>
                              <td data-label="Hora Salida">
                                @if ($info[$j]['horaSal'] == null)
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    {{$info[$j]['horaSal']}}
                                @endif
                                @if ($info[$j]['horaEnt2'] != null)
                                    @if ($info[$j]['horaSal2'] == null)
                                        <br>
                                        <span class="text-danger">Empleado no registró salida</span>
                                    @else
                                        <br>
                                        {{$info[$j]['horaSal2']}}
                                    @endif
                                @endif
                              </td>
                              <td data-label="Modo Entrada">
                                
                                    <span class="text-danger">{{$info[$j]['Modo']}}</span>
                                
                              </td>
                              <td data-label="Total Horas">
                                @if ($info[$j]['horaSal'] == null)
                                    <span class="text-danger">Calculo no disponible</span>
                                @else
                                    {{$info[$j]['totalHoras']}}
                                @endif
                                
                              </td>
                            </tr>  
                        @endfor 
                    @endif
                  </table>
                @break

                @case(6)
                <table class=" shadow table table-bordered border-dark ">
                  <tr class="bg-primary text-light  fw-bold text-center">
                    
                      <td colspan="7"> 
                        <span class="fs-5"> {{ $nombreEmpleado }}  - {{ $departamento[0]}} </span>
                      </td>
                    
                  </tr>
                  <tr >
                    <td>Fecha</td>                    
                    <td >Hora Entrada</td>
                    <td>Hora Salida</td>
                    <td>Modo Entrada</td>
                    <td >Total Horas</td> 
                  </tr>
                  @if ($ctData == 0)
                        <tr class=" text-secondary  fw-bold text-center">
                      
                            <td colspan="7">
                              <span class="fs-4"> No hay información disponible </span>
                            </td>
                          
                        </tr> 
                  @else
                      @for ($j = 0; $j < $ctData; $j++)
                            <tr>
                              <td data-label="Fecha">{{$info[$j]['fecha']}}</td>
                              
                              <td data-label="Hora Entrada">
                                @if ($info[$j]['horaEnt'] == null)
                                    <span class="text-danger">Empleado no registró entrada</span>
                                @else
                                    {{$info[$j]['horaEnt']}}
                                @endif
                                @if ($info[$j]['horaEnt2'] != null)
                                  <br> 
                                  {{$info[$j]['horaEnt2']}}
                                @endif
                              </td>
                              <td data-label="Hora Salida">
                                @if ($info[$j]['horaSal'] == null)
                                    <span class="text-danger">Empleado no registró salida</span>
                                @else
                                    {{$info[$j]['horaSal']}}
                                @endif
                                @if ($info[$j]['horaEnt2'] != null)
                                    @if ($info[$j]['horaSal2'] == null)
                                        <br>
                                        <span class="text-danger">Empleado no registró salida</span>
                                    @else
                                        <br>
                                        {{$info[$j]['horaSal2']}}
                                    @endif
                                @endif
                              </td>
                              <td data-label="Modo Entrada">
                                
                                    <span class="text-danger">{{$info[$j]['Modo']}}</span>
                                
                              </td>
                              <td data-label="Total Horas">
                                @if ($info[$j]['horaSal'] == null)
                                    <span class="text-danger">Calculo no disponible</span>
                                @else
                                    {{$info[$j]['totalHoras']}}
                                @endif
                                
                              </td>
                            </tr>  
                        @endfor 
                    @endif
                  </table>
                
            
    @endswitch
     
  </div>
@endsection

@section('CustomsJS')
   
    <script>
      $( document ).ready(function () {
          $('#grupoDepartamentos').hide();
          $('#grupoEmpleadosDepartamento').hide();
          $('#cedula').hide();

          setTimeout(function() {
            $("#alert-box").alert('close');
          }, 3750);
       
          startTime();
          function startTime() {
              var today = new Date();
              var hr = today.getHours();
              var min = today.getMinutes();
              var sec = today.getSeconds();
              ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
              hr = (hr == 0) ? 12 : hr;
              hr = (hr > 12) ? hr - 12 : hr;
              //Add a zero in front of numbers<10
              hr = checkTime(hr);
              min = checkTime(min);
              sec = checkTime(sec);
              document.getElementById("reloj").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
                        
              var time = setTimeout(function(){ startTime() }, 500);
          }

          function checkTime(i) {
              if (i < 10) {
                  i = "0" + i;
              }
              return i;
          }

      });

      $('#consultaHoy').change(function(e){
      
        e.preventDefault();
        if (this.checked) {
          $('#ctrlFechaFin').attr('disabled', true);
        // $('#ctrlFechaFin').hide();
        } else {
          $('#ctrlFechaFin').removeAttr('disabled');
        // $('#ctrlFechaFin').show(); 
        }
      });

      $('#consultaPorDepartamento').on('change',function (e) { 
        e.preventDefault();
        if (this.checked) { 
          $('#grupoDepartamentos').show();
          $('#grupoEmpleadosDepartamento').hide();
          $('#cedula').hide();
          $('#selDepartamento').empty();
          $.get('departamentos', function(resp){ 
            $('#selDepartamento').append('<option value="Todos">-- Seleccione --</option>');
            for (i = 0; i < resp.length; i++) {
              $('#selDepartamento').append('<option value="'+resp[i].codigo +'">'+ resp[i].nombre +'</option>');
            }
          });
          
        }else{ 
          $('#grupoDepartamentos').hide();
          $('#grupoEmpleadosDepartamento').hide();
          $('#cedula').show();
          $('#selDepartamento').empty();
          $('#selEmpleadoDepartamento').empty();
          
        }
      });

      $('#selDepartamento').on('change',function (e) { 
        e.preventDefault();
        $('#grupoEmpleadosDepartamento').show();
        //$('#grupoEmpleadosDepartamento').empty();
        $('#selEmpleadoDepartamento').empty();
        codigo = $('#selDepartamento').val();
        $.get('departamento-' + codigo + '/empleados', function(resp){ 
            
            $('#selEmpleadoDepartamento').append('<option value="Todos">Todos</option>');
            for (i = 0; i < resp.length; i++) {
              
              $('#selEmpleadoDepartamento').append('<option value="'+resp[i].cedula +'">'+ resp[i].primer_nombre + ' ' + resp[i].primer_apellido +'</option>');
            }
          })
      });

      $('#consultaPorCedula').on('change',function (e) { 
        e.preventDefault();
        if (this.checked) { 
          $('#grupoDepartamentos').hide();
          $('#grupoEmpleadosDepartamento').hide();
          $('#cedula').show();
         
        }else{ 
          $('#grupoDepartamentos').show();
          $('#cedula').hide();
        
          
        }
      });

      function soloNumeros(e)  {
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 48 && key <= 57) || (key==8))
      }        
    </script>
@endsection

