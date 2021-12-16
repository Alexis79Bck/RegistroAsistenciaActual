 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <!-- Hojas de Estilos --> 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/normalize.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" >
    
     <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap-datetimepicker.min.css') }}" > 
  {{--  <link rel="stylesheet" type="text/css" href="{{ asset('css/fontsawesome/all.min.css') }}">--}}
   
    <!-- Fuente Personalizada -->
    <style>
      .page-break {
          page-break-after: always;
      }
      @page { margin: 12px 50px;} 
          /* #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; } 
          #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; } 
          #footer .page:after { content: counter(page, upper-roman); } */
      </style>
    
    @yield('CustomsCSS')
   
  </head>

  <body>
    <div class="container-fluid">
      <div class="row align-items-center ">
        <div class="col-md-6 col-lg">
          <div class="fs-6 fw-bold  " style="color: #014a97;">Hotel Plaza Meru</div>
          {{-- <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png')}}" width="33%" height="50%"> --}}
        </div>
        
        <div class="col-md-6 col-lg mx-auto w-100 " style="margin-bottom: 0.75rem;">
          <div class="fs-5 fw-bold text-center " style="color: #014a97; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; padding-bottom:inherit">
            Reporte de Asistencia {{ $titulo }} <br>
            @if ($tipoReporte == 5 || $tipoReporte == 6 )
               <span class="text-dark fs-5 " style="color:black; font-style:italic;">{{$data[0]['nombre']}} -  {{$data[0]['cedula']}}</span> <br>
            @endif
          
          @if ($tipoReporte ==1 || $tipoReporte == 3 || $tipoReporte == 5)
             Desde {{ $fechaInicio }} - hasta {{ $fechaFin }}    
          @else
            Fecha {{ $fechaInicio }}
          @endif 
          </div>
          
        </div>
         <br>

      </div>

      <div class="row mt-2">
        @yield('content')
      </div>  
     

    </div>
  </body>