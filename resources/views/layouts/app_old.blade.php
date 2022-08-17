 
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
    
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap-datetimepicker.min.css') }}" > --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontsawesome/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/jquery-ui.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/jquery-ui-timepicker-addon.css') }}" >
    
    
    <!-- Fuente Personalizada -->
    <link rel="stylesheet" href="{{ asset('/css/fonts/raleway.css') }}">
    
    
    
    @yield('CustomsCSS')
    @livewireStyles
    <style>
      body {
        font-family: "Raleway";
        font-size: 14px;
        background-color:whitesmoke
      }
      .active{
        background-color: whitesmoke;
        color: blue;
      }

      .nav-link{
        color:white;
      }
      .nav-item:hover{
        background-color: whitesmoke;
        color: blue;
      }
      .active .nav-link{
       font-weight: bold;
       text-decoration: underline;
        color: blue;
      }
      
    </style>
</head>

<body onload="alertFunc()">
  <div class="container-fluid  bg-light">
    <div class="row sticky-top " style="background-color: #014a97;">
      @livewire('menu-top-bar')  
    </div> 
  </div>

  <div class="container overflow-auto ">
         
          @yield('content')

  </div>

  <div class="container-fluid">
      <div class="row {{Route::currentRouteName() != 'registro_manual'  ? 'fixed-bottom' : ''}} mt-4" style="color: whitesmoke; background-color: #014a97">
        @livewire('footer-bottom-bar')
      </div> 
  </div>
  

  {{-- <div class="container align-item-center">
    <div class="card ">
      <div class="card-header bg-primary text-light">
        <h4 class="display-6 text-center">REGISTRO DE ASISTENCIA</h4>
      </div>
      <div class="card-body">
        @yield('card-content')
      </div>
      
    </div>
  </div> --}}


  <script src="{!! asset('js/bootstrap/bootstrap.bundle.min.js') !!}"></script>  
  <script src="{!! asset('js/jquery/moment.min.js') !!}"></script> 
  <script src="{!! asset('js/jquery/jquery-3.5.1.min.js') !!}"></script>
  <script src="{!! asset('js/jquery/jquery-ui.min.js') !!}"></script>
  <script src="{!! asset('js/jquery/jquery-ui-timepicker-addon.js') !!}"></script>
  {{-- <script src="{!! asset('js/bootstrap/bootstrap-datetimepicker.min.js') !!}"></script> --}}
  
  
  @livewireScripts
  @yield('CustomsJS')
   <script >
      let i = 0;

      function alertFunc() {
       
        window.livewire.emit('regPunchData');
        
       
        setTimeout(alertFunc, 60000);
      } 
  </script>
</body>
</html>