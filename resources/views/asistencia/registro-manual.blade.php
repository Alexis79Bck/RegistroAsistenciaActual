@extends('layouts.app')

@section('content')
<div class="row row-cols-3 align-items-center mt-2">
  <div class="col  ">
    <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png')}}" width="33%" height="50%">
  </div>
  <div class="col ">
    <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Asistencia Manual</div>
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
<div class="display-6 fs-6 fw-bold text-center g-0" style="color: #014a97;">Empleados</div>
<div class="container">
  <div class="row ">
    {!! Form::open(['route'=>'guardar_registro_manual','method'=>'POST','class'=>'form ']) !!}
      @livewire('lista-empleados')
      <button type="submit" class="btn btn-sm btn-success"  >Guardar</button>
    {!! Form::close() !!}  
  </div>
</div>



@endsection


@section('CustomsJS')
{{-- <script src="{{ asset('js/semanticUI/semantic.min.js')}}"></script> --}}

<script type="text/javascript">
 
   
  
</script>

<script>
   
$( document ).ready(function () {
    let d = new Date();
    startTime();
    

    setTimeout(function() {
        $("#alert-box").alert('close');
    }, 7500);

    if ((d.getMonth() + 1) < 10) {
      $('#fecha').append('Fecha: ' + d.getDate() + '-0' + (d.getMonth() + 1) + '-' + d.getFullYear());  
    }else{
      $('#fecha').append('Fecha: ' + d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear());
    }

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

function soloNumeros(e)  {
      var key = window.Event ? e.which : e.keyCode
      return ((key >= 48 && key <= 57) || (key==8))
}

$("#lafecha").on('change blur', function(){  
        
        
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
        
 
     }) 

     

     function HrSalNoMenorHrEnt(id) {
      $('#HrSal-' + id).on('change', function(e){
        e.preventDefault(); 
        if (Date.parse($("#lafecha").val() + ' ' + $('#HrSal-' + id).val()) <= Date.parse($("#lafecha").val() + ' ' + $('#HrEnt-' + id).val()) ) {
          $('#HrSal-' + id).removeClass('is-valid');
          $('#HrSal-' + id).addClass('is-invalid');
          $('.invalid-feedback').text('La hora de Salida no debe ser menor o igual a la hora de Entrada.') 
        }else{
          $('#HrSal-' + id).removeClass('is-invalid');
          $('#HrSal-' + id).addClass('is-valid');
        }
      }); 

     }

     function HrSal2NoMenorHrEnt2(id) {
      $('#HrSal2-' + id).on('change', function(e){
        e.preventDefault(); 
        if (Date.parse($("#lafecha").val() + ' ' + $('#HrSal2-' + id).val()) <= Date.parse($("#lafecha").val() + ' ' + $('#HrEnt2-' + id).val()) ) {
          $('#HrSal2-' + id).removeClass('is-valid');
          $('#HrSal2-' + id).addClass('is-invalid');
          $('.invalid-feedback').text('La hora de Salida no debe ser menor o igual a la hora de Entrada.') 
        }else{
          $('#HrSal2-' + id).removeClass('is-invalid');
          $('#HrSal2-' + id).addClass('is-valid');
        }
      }); 

     }

     function HrEnt2NoMenorHrSal(id) {
      $('#HrEnt2-' + id).on('change', function(e){
        e.preventDefault(); 
        
        if (Date.parse($("#lafecha").val() + ' ' + $('#HrEnt2-' + id).val()) <= Date.parse($("#lafecha").val() + ' ' + $('#HrSal-' + id).val())) {
          $('#HrEnt2-' + id).removeClass('is-valid');
          $('#HrEnt2-' + id).addClass('is-invalid');
          $('.invalid-feedback').text('La hora de Entrada no debe ser menor o igual a la anterior hora de Salida.') 
        }else{
          $('#HrEnt2-' + id).removeClass('is-invalid');
          $('#HrEnt2-' + id).addClass('is-valid');
        }
      }); 

     }

     function NuevoHrEntHrSal(id) {  
        if (document.getElementById('HrSal-' + id).value == '') {
          
          $('#HrSal-' + id).addClass('is-invalid');
          $('.invalid-feedback').text('No puede existir valor vacío en Hora Salida') 
          
        }else{
          $('#HrSal-' + id).removeClass('is-invalid');
          
                if ($('#agregarEntSal-' + id).hasClass('fa-plus-circle')) {
                      $('#agregarEntSal-' + id).addClass('fa-minus-circle');
                      $('#agregarEntSal-' + id).removeClass('fa-plus-circle');
                      $('#chkAgregarEntSal-' + id).attr('value','activo');
                      
                      $('#grupoEnt2-' + id).show();
                      $('#grupoSal2-' + id).show();
                }else{ 
                      console.log('Entro en ELSE condicion cuando - ...')
                      $('#agregarEntSal-' + id).addClass('fa-plus-circle');
                      $('#agregarEntSal-' + id).removeClass('fa-minus-circle');
                      
                      $('#chkAgregarEntSal-' + id).attr('value','inactivo');
                      $('#grupoEnt2-' + id).hide();
                      $('#grupoSal2-' + id).hide();
                } 
          }
          
           
      }
        
    

</script>
    
@endsection
