@extends('layouts.app')

@section('content')

  <div class="row row-cols-3 align-items-center mt-2">
    <div class="col  ">
      <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png')}}" width="33%" height="50%">
    </div>
    <div class="col ">
      <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Asistencia</div>
    </div>
    <div class="col">
      <p></p>
    </div>
  </div>
  <div class="row row-cols-3 align-items-center mb-3">
    <div class="col">
      {{-- <span class=" fs-6 "> Usuario: « Nombre del Usuario »</span> --}}
    </div>
    <div class="col   ">
      <div class="fs-4 fw-bold text-center " style="color: #014a97;" id="reloj"></div>
    </div>
    <div class="col ">
      <div class=" fs-5 float-end" id="fecha"> </div>
    </div>
    
  </div>
  <div class="row justify-content-end">
    <div class="col">
      @include('layouts.partials.mensajes')
    </div>
  </div>
  
  <hr class="dropdown-divider">
  
{{--  @livewire('formulario-registro') --}}
  
  <div class="row row-cols-3 ">
    <div class="col w-25">
        <div class=" form-group"> 
            <div class="form-check">
                <input class="form-check-input busqueda" type="radio" name="busqueda" id="opCedula" value="cedula" checked>
                {!! Form::label('opCedula', 'Cédula:', ['class'=>'form-check-label']) !!}                
            </div> 
            <div class="input-group input-group-sm" id="grupoCedula">    
              {!! Form::text('cedula', null, ['id'=>'cedula', 'class'=>'form-control', 'onKeyPress'=>'return soloNumeros(event)','maxlength'=>'9']) !!}
              
              <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorCedula" ><i class="fas fa-search text-light"></i></a> 
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
                <option value="{{ $item->codigo }}">{{$item->nombre}}</li>
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
              
              <select name="empleados" id="selEmpleados" class="form-select form-select-sm">
              </select>             
              {{-- <a href="#" class="btn btn-success input-group-text" data-bs-toggle="tooltip" title="Buscar..." id="buscaPorSeleccion" ><i class="fas fa-search text-light"></i></a> --}}
          </div>
           {{-- @livewire('busca-empleado-por-seleccion')--}}

        </div>

    </div>

  </div> 
  <hr>
  <div class="row  justify-content-center py-4 mt-4 " id="busquedaEmpleado">
    @livewire('resultado-busqueda')
  </div>
   

@endsection


@section('CustomsJS')
{{-- <script src="{{ asset('js/semanticUI/semantic.min.js')}}"></script> --}}
<script>
   
$( document ).ready(function () {
    let d = new Date();

    startTime();

    setTimeout(function() {
        $("#alert-box").alert('close');
    }, 7500);

    $('#fecha').append('Fecha: ' + d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear());
    $('#selDepartamento').hide();
    $('#grupoEmpleados').hide();
    $('#busquedaEmpleado').hide();
    
    $('#opDepartamento').on('click focus', function () { 
      
        $('#selDepartamento').show();
        $('#grupoCedula').hide();
        $('#busquedaEmpleado').hide();
        $('#titulo').empty();
        $('#subtitulo').empty();
        $("#botonesRegistro").hide()
    });

    $('#opCedula').on('click focus', function () {
      
      $('#selDepartamento').hide();
      $('#grupoEmpleados').hide();
      $('#grupoCedula').show();
      $('#busquedaEmpleado').hide();
      $('#titulo').empty();
      $('#subtitulo').empty();
      $("#botonesRegistro").hide()
        
    });

    $('#cedula').on('change', function () {
      
      $('#selDepartamento').hide();
      $('#grupoEmpleados').hide();
      $('#grupoCedula').show();
      $('#busquedaEmpleado').hide();
      $('#titulo').empty();
      $('#subtitulo').empty();
      $("#botonesRegistro").hide()
        
    });

 
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
        document.getElementById("reloj").innerHTML = hr + ":" + min + ":" + sec + " " + ap ;
                  
        var time = setTimeout(function(){ startTime() }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    $("#modalEditarAsistencia").on('load', function(){    
      console.log('Entro en modal...')
          $('.inpEntrada').timepicker({
          
          timeOnly: true,
          timeOnlyTitle: '',
          timeText: '',
          currentText:'Hoy',
          closeText:'Hecho',
          amNames: ['AM', 'A'],
          pmNames: ['PM', 'P'],
          hourText: 'Hora',
          minuteText: 'Minutos',
          timeFormat: 'hh:mm tt',
          showButtonPanel:false,
          }); 
        });  
        
        
});


function soloNumeros(e)  {
      var key = window.Event ? e.which : e.keyCode
      return ((key >= 48 && key <= 57) || (key==8))
}

$('#selDepartamento').change(function (e) { 
  e.preventDefault();
  $('#grupoEmpleados').show();
  $.get('departamento-' + e.target.value  + '/empleados', function(resp){ 
   
    $('#selEmpleados').empty();
    $('#mensajeTexto').empty();
    if (resp.length == 0) {
      $('#divEmpleados').hide();
      $('#mensajeTexto').show();
      $('#mensajeTexto').append(' No hay registro de empleados para este Departamento.');
    }else{
      $('#divEmpleados').show();
      $('#mensajeTexto').hide();
      $('#selEmpleados').append('<option >-- Seleccione --</option>');
      for (i = 0; i < resp.length; i++) {
        $('#selEmpleados').append('<option value="'+resp[i].cedula +'">'+ resp[i].primer_nombre + '  ' + resp[i].primer_apellido +'</option>');
       
         
      }
    }
  });  
});

$('#buscaPorCedula').click(function(e){
  e.preventDefault();
  if ($("#cedula").val() == "") {
     alert('Debe ingresar una cédula. No se admite campo vacío.')
  }else{ 
      url = 'busca-empleado/' + $('#cedula').val()
      $.get(url, function(resp){ 
          $('#titulo').empty();
          $('#subtitulo').empty();
          $("#botonesRegistro").show()
          llenarCamposResultadosBusqueda(resp)

          $('#cedula').val('');
          $('#busquedaEmpleado').show();

          if (resp.registro != null) {

              if (resp.registro.hora_entrada_2 != null) {
                $("#segundaFila").show()
              } else {
                $("#segundaFila").hide()
              }

              $('#botonMarcaEditar').removeClass('disabled');

              if (resp.registro.hora_entrada != null   &&  resp.registro.hora_entrada_2 != null && resp.registro.hora_salida != null   &&  resp.registro.hora_salida_2 != null) {
                  $('#botonMarcaEntrada').addClass('disabled');
                  $('#botonMarcaSalida').addClass('disabled');
                  temporEnt = resp.registro.hora_entrada.split(' ');
                  tmpHrEnt = temporEnt[1].split(':');
                  temporSal = resp.registro.hora_salida.split(' ');
                  tmpHrSal = temporSal[1].split(':');
                  temporEnt2 = resp.registro.hora_entrada_2.split(' ');
                  tmpHrEnt2 = temporEnt2[1].split(':');
                  temporSal2 = resp.registro.hora_salida_2.split(' ');
                  tmpHrSal2 = temporSal2[1].split(':');
                  llenarControlesHE1ModalEditar(tmpHrEnt)
                  llenarControlesHS1ModalEditar(tmpHrSal)
                  llenarControlesHE2ModalEditar(tmpHrEnt2)
                  llenarControlesHS2ModalEditar(tmpHrSal2)
                  alert('Este empleado ya ha cerrado su asistencia.')
              }else{
                  
                  if (resp.registro.hora_entrada != null &&  resp.registro.hora_entrada_2 == null && resp.registro.hora_salida == null   &&  resp.registro.hora_salida_2 == null) {
                        
                    habilitarBotonMarcaSalida()
                    temporEnt = resp.registro.hora_entrada.split(' ');
                    tmpHrEnt = temporEnt[1].split(':');
                    llenarControlesHE1ModalEditar(tmpHrEnt)

                  }

                  if (resp.registro.hora_entrada != null && resp.registro.hora_salida != null &&  resp.registro.hora_entrada_2 == null  &&  resp.registro.hora_salida_2 == null) { 
                    habilitarBotonMarcaEntrada()
                    temporEnt = resp.registro.hora_entrada.split(' ');
                    tmpHrEnt = temporEnt[1].split(':');
                    temporSal = resp.registro.hora_salida.split(' ');
                    tmpHrSal = temporSal[1].split(':');
                    llenarControlesHE1ModalEditar(tmpHrEnt)
                    llenarControlesHS1ModalEditar(tmpHrSal)
                    
                  }
                  
                  if (resp.registro.hora_entrada != null &&  resp.registro.hora_entrada_2 != null &&  resp.registro.hora_salida != null   &&  resp.registro.hora_salida_2 == null) { 
                  
                    habilitarBotonMarcaSalida()
                    temporEnt = resp.registro.hora_entrada.split(' ');
                    tmpHrEnt = temporEnt[1].split(':');
                    temporEnt2 = resp.registro.hora_entrada_2.split(' ');
                    tmpHrEnt2 = temporEnt2[1].split(':');
                    temporSal = resp.registro.hora_salida.split(' ');
                    tmpHrSal = temporSal[1].split(':');
                    llenarControlesHE1ModalEditar(tmpHrEnt)
                    llenarControlesHS1ModalEditar(tmpHrSal)
                    llenarControlesHE2ModalEditar(tmpHrEnt2)

                  }
              }     
            
          }else{
          $('#botonMarcaEditar').addClass('disabled');
          $('#botonMarcaEntrada').removeClass('disabled');
          $('#botonMarcaSalida').addClass('disabled');
        }
            
      })
      .fail(function() {
          alert( "El nro. de cédula no existe o no está registrada." );
      });
  }
   
});

$('#selEmpleados').change(function(e){
  e.preventDefault();
  url = 'busca-empleado/' + $('#selEmpleados').val()
  $.get(url, function(resp){ 
    $('#titulo').empty();
    $('#subtitulo').empty();
    $("#botonesRegistro").show()
    llenarCamposResultadosBusqueda(resp)
    
    $('#cedula').val('');
   
    $('#busquedaEmpleado').show();
    if (resp.registro != null) {
          if (resp.registro.hora_entrada_2 != null) {
            $("#segundaFila").show()
          } else {
            $("#segundaFila").hide()
          }

          $('#botonMarcaEditar').removeClass('disabled');

          if (resp.registro.hora_entrada != null   &&  resp.registro.hora_entrada_2 != null && resp.registro.hora_salida != null   &&  resp.registro.hora_salida_2 != null) {
              $('#botonMarcaEntrada').addClass('disabled');
              $('#botonMarcaSalida').addClass('disabled');
              temporEnt = resp.registro.hora_entrada.split(' ');
              tmpHrEnt = temporEnt[1].split(':');
              temporSal = resp.registro.hora_salida.split(' ');
              tmpHrSal = temporSal[1].split(':');
              temporEnt2 = resp.registro.hora_entrada_2.split(' ');
              tmpHrEnt2 = temporEnt2[1].split(':');
              temporSal2 = resp.registro.hora_salida_2.split(' ');
              tmpHrSal2 = temporSal2[1].split(':');
              llenarControlesHE1ModalEditar(tmpHrEnt)
              llenarControlesHS1ModalEditar(tmpHrSal)
              llenarControlesHE2ModalEditar(tmpHrEnt2)
              llenarControlesHS2ModalEditar(tmpHrSal2)
              alert('Este empleado ya ha cerrado su asistencia.')
          }else{
              
              if (resp.registro.hora_entrada != null &&  resp.registro.hora_entrada_2 == null && resp.registro.hora_salida == null   &&  resp.registro.hora_salida_2 == null) {
                    
                habilitarBotonMarcaSalida()
                temporEnt = resp.registro.hora_entrada.split(' ');
                tmpHrEnt = temporEnt[1].split(':');
                llenarControlesHE1ModalEditar(tmpHrEnt)

              }

              if (resp.registro.hora_entrada != null && resp.registro.hora_salida != null &&  resp.registro.hora_entrada_2 == null  &&  resp.registro.hora_salida_2 == null) { 
                habilitarBotonMarcaEntrada()
                temporEnt = resp.registro.hora_entrada.split(' ');
                tmpHrEnt = temporEnt[1].split(':');
                temporSal = resp.registro.hora_salida.split(' ');
                tmpHrSal = temporSal[1].split(':');
                llenarControlesHE1ModalEditar(tmpHrEnt)
                llenarControlesHS1ModalEditar(tmpHrSal)
                
              }
              
              if (resp.registro.hora_entrada != null &&  resp.registro.hora_entrada_2 != null &&  resp.registro.hora_salida != null   &&  resp.registro.hora_salida_2 == null) { 
              
                habilitarBotonMarcaSalida()
                temporEnt = resp.registro.hora_entrada.split(' ');
                tmpHrEnt = temporEnt[1].split(':');
                temporEnt2 = resp.registro.hora_entrada_2.split(' ');
                tmpHrEnt2 = temporEnt2[1].split(':');
                temporSal = resp.registro.hora_salida.split(' ');
                tmpHrSal = temporSal[1].split(':');
                llenarControlesHE1ModalEditar(tmpHrEnt)
                llenarControlesHS1ModalEditar(tmpHrSal)
                llenarControlesHE2ModalEditar(tmpHrEnt2)

              }
          }     
        
    }else{
          $('#botonMarcaEditar').addClass('disabled');
          $('#botonMarcaEntrada').removeClass('disabled');
          $('#botonMarcaSalida').addClass('disabled');
    }    
  });
});

$('#grupoColSalida').on('mouseover mouseleave', function () {

  if ($('#editarMdEntrada').val() == 'am') { 
    if ($('#editarHoraEntrada').val() == 12) { 
       horaEntrada = (Number($('#editarHoraEntrada').val()) - 12) + ':' + $('#editarMinEntrada').val(); 
    } else { 
       horaEntrada = $('#editarHoraEntrada').val() + ':' + $('#editarMinEntrada').val();    
    }
    
  }else{ 
    if ($('#editarHoraEntrada').val() < 12) { 
       horaEntrada = (Number($('#editarHoraEntrada').val()) + 12) + ':' + $('#editarMinEntrada').val(); 
    } else { 
       horaEntrada = $('#editarHoraEntrada').val() + ':' + $('#editarMinEntrada').val();    
    }
  } 
  if ($('#editarMdSalida').val() == 'am') { 
    if ($('#editarHoraSalida').val() == 12) { 
      horaSalida = (Number($('#editarHoraSalida').val()) - 12) + ':' + $('#editarMinSalida').val(); 
    } else { 
      horaSalida = $('#editarHoraSalida').val() + ':' + $('#editarMinSalida').val();  
    }
    
  }else{ 
    if ($('#editarHoraSalida').val() < 12) { 
      horaSalida = (Number($('#editarHoraSalida').val()) + 12) + ':' + $('#editarMinSalida').val(); 
    } else { 
      horaSalida = $('#editarHoraSalida').val() + ':' + $('#editarMinSalida').val();    
    }
  }  
   fh = new Date;
   fechaHoy = fh.getFullYear() + '-' + (fh.getMonth() + 1)  + '-' + fh.getDate();
  
   if ( Date.parse(fechaHoy + ' ' + horaSalida) != Date.parse(fechaHoy + ' 1:00')) {
      if ( Date.parse(fechaHoy + ' ' + horaSalida) < Date.parse(fechaHoy + ' ' + horaEntrada) ) {
        $('#botonGuardarEditar').attr('disabled', 'true');
        $('#editarHoraSalida').removeClass('is-valid');
        $('#editarMinSalida').removeClass('is-valid');
        $('#editarMdSalida').removeClass('is-valid');
        $('#editarHoraSalida').addClass('is-invalid');
        $('#editarMinSalida').addClass('is-invalid');
        $('#editarMdSalida').addClass('is-invalid');
        $('#filaMensaje').empty()
        $('#filaMensaje').text('La hora de Salida no debe ser menor a la 1ra. Hora de Entrada.')
      }else{
        $('#filaMensaje').empty()
        $('#botonGuardarEditar').removeAttr('disabled');
        $('#editarHoraSalida').removeClass('is-invalid');
        $('#editarMinSalida').removeClass('is-invalid');
        $('#editarMdSalida').removeClass('is-invalid');
        $('#editarHoraSalida').addClass('is-valid');
        $('#editarMinSalida').addClass('is-valid');
        $('#editarMdSalida').addClass('is-valid');
        
      }
   }else{
      $('#botonGuardarEditar').removeAttr('disabled');
        $('#editarHoraSalida').removeClass('is-valid');
        $('#editarMinSalida').removeClass('is-valid');
        $('#editarMdSalida').removeClass('is-valid');
        $('#editarHoraSalida').removeClass('is-invalid');
        $('#editarMinSalida').removeClass('is-invalid');
        $('#editarMdSalida').removeClass('is-invalid');

   }
});


$('#grupoColEntrada2').on('mouseover mouseleave', function () {

if ($('#editarMdEntrada2').val() == 'am') { 
  if ($('#editarHoraEntrada2').val() == 12) { 
     horaEntrada = (Number($('#editarHoraEntrada2').val()) - 12) + ':' + $('#editarMinEntrada2').val(); 
  } else { 
     horaEntrada = $('#editarHoraEntrada2').val() + ':' + $('#editarMinEntrada2').val();    
  }
  
}else{ 
  if ($('#editarHoraEntrada2').val() < 12) { 
     horaEntrada = (Number($('#editarHoraEntrada2').val()) + 12) + ':' + $('#editarMinEntrada2').val(); 
  } else { 
     horaEntrada = $('#editarHoraEntrada2').val() + ':' + $('#editarMinEntrada2').val();    
  }
} 
if ($('#editarMdSalida').val() == 'am') { 
  if ($('#editarHoraSalida').val() == 12) { 
    horaSalida = (Number($('#editarHoraSalida').val()) - 12) + ':' + $('#editarMinSalida').val(); 
  } else { 
    horaSalida = $('#editarHoraSalida').val() + ':' + $('#editarMinSalida').val();  
  }
  
}else{ 
  if ($('#editarHoraSalida').val() < 12) { 
    horaSalida = (Number($('#editarHoraSalida').val()) + 12) + ':' + $('#editarMinSalida').val(); 
  } else { 
    horaSalida = $('#editarHoraSalida').val() + ':' + $('#editarMinSalida').val();    
  }
}  
 fh = new Date;
 fechaHoy = fh.getFullYear() + '-' + (fh.getMonth() + 1)  + '-' + fh.getDate();

 if ( Date.parse(fechaHoy + ' ' + horaEntrada) != Date.parse(fechaHoy + ' 1:00')) {
    if ( Date.parse(fechaHoy + ' ' + horaEntrada) < Date.parse(fechaHoy + ' ' + horaSalida) ) {
      $('#botonGuardarEditar').attr('disabled', 'true');
      $('#editarHoraEntrada2').removeClass('is-valid');
      $('#editarMinEntrada2').removeClass('is-valid');
      $('#editarMdEntrada2').removeClass('is-valid');
      $('#editarHoraEntrada2').addClass('is-invalid');
      $('#editarMinEntrada2').addClass('is-invalid');
      $('#editarMdEntrada2').addClass('is-invalid');
      $('#filaMensaje').empty()
      $('#filaMensaje').text('La 2da. Hora de Entrada no debe ser menor a la 1ra. Hora de Salida.')
    }else{
      $('#filaMensaje').empty()
      $('#botonGuardarEditar').removeAttr('disabled');
      $('#editarHoraEntrada2').removeClass('is-invalid');
      $('#editarMinEntrada2').removeClass('is-invalid');
      $('#editarMdEntrada2').removeClass('is-invalid');
      $('#editarHoraEntrada2').addClass('is-valid');
      $('#editarMinEntrada2').addClass('is-valid');
      $('#editarMdEntrada2').addClass('is-valid');
      
    }
 }else{
    $('#botonGuardarEditar').removeAttr('disabled');
      $('#editarHoraEntrada2').removeClass('is-valid');
      $('#editarMinEntrada2').removeClass('is-valid');
      $('#editarMdEntrada2').removeClass('is-valid');
      $('#editarHoraEntrada2').removeClass('is-invalid');
      $('#editarMinEntrada2').removeClass('is-invalid');
      $('#editarMdEntrada2').removeClass('is-invalid');

 }
});


$('#grupoColSalida2').on('mouseover mouseleave', function () {

if ($('#editarMdEntrada2').val() == 'am') { 
  if ($('#editarHoraEntrada2').val() == 12) { 
     horaEntrada = (Number($('#editarHoraEntrada2').val()) - 12) + ':' + $('#editarMinEntrada2').val(); 
  } else { 
     horaEntrada = $('#editarHoraEntrada2').val() + ':' + $('#editarMinEntrada2').val();    
  }
  
}else{ 
  if ($('#editarHoraEntrada2').val() < 12) { 
     horaEntrada = (Number($('#editarHoraEntrada2').val()) + 12) + ':' + $('#editarMinEntrada2').val(); 
  } else { 
     horaEntrada = $('#editarHoraEntrada2').val() + ':' + $('#editarMinEntrada2').val();    
  }
} 
if ($('#editarMdSalida2').val() == 'am') { 
  if ($('#editarHoraSalida2').val() == 12) { 
    horaSalida = (Number($('#editarHoraSalida2').val()) - 12) + ':' + $('#editarMinSalida2').val(); 
  } else { 
    horaSalida = $('#editarHoraSalida2').val() + ':' + $('#editarMinSalida2').val();  
  }
  
}else{ 
  if ($('#editarHoraSalida2').val() < 12) { 
    horaSalida = (Number($('#editarHoraSalida2').val()) + 12) + ':' + $('#editarMinSalida2').val(); 
  } else { 
    horaSalida = $('#editarHoraSalida2').val() + ':' + $('#editarMinSalida2').val();    
  }
}  
 fh = new Date;
 fechaHoy = fh.getFullYear() + '-' + (fh.getMonth() + 1)  + '-' + fh.getDate();

 if ( Date.parse(fechaHoy + ' ' + horaSalida) != Date.parse(fechaHoy + ' 1:00')) {
    if ( Date.parse(fechaHoy + ' ' + horaSalida) < Date.parse(fechaHoy + ' ' + horaEntrada) ) {
      $('#botonGuardarEditar').attr('disabled', 'true');
      $('#editarHoraSalida2').removeClass('is-valid');
      $('#editarMinSalida2').removeClass('is-valid');
      $('#editarMdSalida2').removeClass('is-valid');
      $('#editarHoraSalida2').addClass('is-invalid');
      $('#editarMinSalida2').addClass('is-invalid');
      $('#editarMdSalida2').addClass('is-invalid');
      $('#filaMensaje').empty()
      $('#filaMensaje').text('La 2da. Hora de Salida no debe ser menor a la 2da. Hora de Entrada.')
    }else{
      $('#filaMensaje').empty()
      $('#botonGuardarEditar').removeAttr('disabled');
      $('#editarHoraSalida2').removeClass('is-invalid');
      $('#editarMinSalida2').removeClass('is-invalid');
      $('#editarMdSalida2').removeClass('is-invalid');
      $('#editarHoraSalida2').addClass('is-valid');2
      $('#editarMinSalida2').addClass('is-valid');
      $('#editarMdSalida2').addClass('is-valid');
      
    }
 }else{
    $('#botonGuardarEditar').removeAttr('disabled');
      $('#editarHoraSalida2').removeClass('is-valid');
      $('#editarMinSalida2').removeClass('is-valid');
      $('#editarMdSalida2').removeClass('is-valid');
      $('#editarHoraSalida2').removeClass('is-invalid');
      $('#editarMinSalida2').removeClass('is-invalid');
      $('#editarMdSalida2').removeClass('is-invalid');

 }
});


function llenarControlesHE1ModalEditar(Temp){
  
  if (Number(Temp[0]) < 12) {

      if (Number(Temp[0]) == 0) {
          $('#editarHoraEntrada').val(12);
      }else{
          $('#editarHoraEntrada').val(Number(Temp[0]));
      }

      if (Number(Temp[1]) < 10) {
          $('#editarMinEntrada').val('0' + Number(Temp[1]));  
      }else{
          $('#editarMinEntrada').val(Number(Temp[1]));
      }            

      $('#editarMdEntrada').val('am');

  }else{
      if (Number(Temp[0]) == 12) {
          $('#editarHoraEntrada').val(12);
      }else{
          $('#editarHoraEntrada').val(Number(Temp[0]) - 12);
      }

      if (Number(Temp[1]) < 10) {
          $('#editarMinEntrada').val('0' + Number(Temp[1]));  
      }else{
          $('#editarMinEntrada').val(Number(Temp[1]));
      } 

      $('#editarMdEntrada').val('pm');

  }
}

function llenarControlesHS1ModalEditar(Temp){
    if (Number(Temp[0]) < 12) {
            if (Number(Temp[0]) == 0) {
                $('#editarHoraSalida').val(12);
            }else{
                $('#editarHoraSalida').val(Number(Temp[0]));
            }

            if (Number(Temp[1]) < 10) {
                $('#editarMinSalida').val('0' + Number(Temp[1]));
            }else{
                $('#editarMinSalida').val(Number(Temp[1]));
            }

            $('#editarMdSalida').val('am');
          
    }else{
            if (Number(Temp[0]) == 12) {
              $('#editarHoraSalida').val(12);
            }else{
              $('#editarHoraSalida').val(Number(Temp[0]) - 12);
            }

            if (Number(Temp[1]) < 10) {
              $('#editarMinSalida').val('0' + Number(Temp[1]));
            }else{
              $('#editarMinSalida').val(Number(Temp[1]));
            }

            $('#editarMdSalida').val('pm');
    }
}


function llenarControlesHE2ModalEditar(Temp){
  
  if (Number(Temp[0]) < 12) {

      if (Number(Temp[0]) == 0) {
          $('#editarHoraEntrada2').val(12);
      }else{
          $('#editarHoraEntrada2').val(Number(Temp[0]));
      }

      if (Number(Temp[1]) < 10) {
          $('#editarMinEntrada2').val('0' + Number(Temp[1]));  
      }else{
          $('#editarMinEntrada2').val(Number(Temp[1]));
      }            

      $('#editarMdEntrada2').val('am');

  }else{
      if (Number(Temp[0]) == 12) {
          $('#editarHoraEntrada2').val(12);
      }else{
          $('#editarHoraEntrada2').val(Number(Temp[0]) - 12);
      }

      if (Number(Temp[1]) < 10) {
          $('#editarMinEntrada2').val('0' + Number(Temp[1]));  
      }else{
          $('#editarMinEntrada2').val(Number(Temp[1]));
      } 

      $('#editarMdEntrada2').val('pm');

  }
}

function llenarControlesHS2ModalEditar(Temp){
    if (Number(Temp[0]) < 12) {
            if (Number(Temp[0]) == 0) {
                $('#editarHoraSalida2').val(12);
            }else{
                $('#editarHoraSalida2').val(Number(Temp[0]));
            }

            if (Number(Temp[1]) < 10) {
                $('#editarMinSalida2').val('0' + Number(Temp[1]));
            }else{
                $('#editarMinSalida2').val(Number(Temp[1]));
            }

            $('#editarMdSalida2').val('am');
          
    }else{
            if (Number(Temp[0]) == 12) {
              $('#editarHoraSalida2').val(12);
            }else{
              $('#editarHoraSalida2').val(Number(Temp[0]) - 12);
            }

            if (Number(Temp[1]) < 10) {
              $('#editarMinSalida2').val('0' + Number(Temp[1]));
            }else{
              $('#editarMinSalida2').val(Number(Temp[1]));
            }

            $('#editarMdSalida2').val('pm');
    }
}

function llenarCamposResultadosBusqueda(resp) {
        $('#titulo').append(resp.empleado[0].primer_nombre + ' ' + resp.empleado[0].primer_apellido + ' - ' +resp.empleado[0].cedula);
        $('#subtitulo').append(resp.departamento[0].nombre + ' / ' + resp.cargo[0].nombre);
        $('#hnombre').val(resp.empleado[0].primer_nombre);
        $('#hapellido').val(resp.empleado[0].primer_apellido);
        $('#hcedula').val(resp.empleado[0].cedula);
        $('#hdepartamento').val(resp.departamento[0].nombre);
        $('#hcargo').val(resp.cargo[0].nombre);
        $('#hhnombre').val(resp.empleado[0].primer_nombre);
        $('#hhapellido').val(resp.empleado[0].primer_apellido);
        $('#hhcedula').val(resp.empleado[0].cedula);
        $('#hhdepartamento').val(resp.departamento[0].nombre);
        $('#hhcargo').val(resp.cargo[0].nombre); 
        $('#hgnombre').val(resp.empleado[0].primer_nombre);
        $('#hgapellido').val(resp.empleado[0].primer_apellido);
        $('#hgcedula').val(resp.empleado[0].cedula);
        $('#hgdepartamento').val(resp.departamento[0].nombre);
        $('#hgcargo').val(resp.cargo[0].nombre);   

}

function habilitarBotonMarcaSalida() {
  $('#botonMarcaSalida').removeClass('disabled');
  $('#botonMarcaEntrada').addClass('disabled'); 
}

function habilitarBotonMarcaEntrada() {
  $('#botonMarcaEntrada').removeClass('disabled');
  $('#botonMarcaSalida').addClass('disabled'); 
}

</script>
    
@endsection

{{-- @section('CustomsCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/semanticUI/semantic.min.css') }}">
@endsection --}}