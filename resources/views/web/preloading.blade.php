<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <!-- Hojas de Estilos -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontsawesome/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/jquery-ui-timepicker-addon.css') }}">


    <!-- Fuente Personalizada -->
    <link rel="stylesheet" href="{{ asset('/css/fonts/raleway.css') }}">
    <style>
        .prifix_loading_box {
            position: relative;
            width: 200px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .prifix_loading_box span {
            display: block;
            height: 20px;
            width: 20px;
            background: #d36a00;
            border-radius: 50%;
            animation: all-effect 0.512s linear infinite alternate;
            transform: scale(0)
        }

        .prifix_loading_box span:nth-child(1) {
            animation-delay: 0.1s
        }

        .prifix_loading_box span:nth-child(2) {
            animation-delay: 0.2s;

        }

        .prifix_loading_box span:nth-child(4) {
            animation-delay: 0.4s;

        }

        .prifix_loading_box span:nth-child(4) {
            animation-delay: 0.8s;
            background: #019751
        }

        .prifix_loading_box span:nth-child(5) {
            animation-delay: 0.16s;
            background: #019751
        }

        .prifix_loading_box span:nth-child(6) {
            animation-delay: 0.32s;
            background: #019751
        }

        .prifix_loading_box span:nth-child(7) {
            animation-delay: 0.64s;
            background: #014a97
        }

        .prifix_loading_box span:nth-child(8) {
            animation-delay: 0.128s;
            background: #014a97
        }

        .prifix_loading_box span:nth-child(9) {
            animation-delay: 0.256s;
            background: #014a97
        }

        @keyframes all-effect {
            100% {
                transform: scale(1.25)
            }
        }
    </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">

    <div class="">
        <img class=" img-fluid" src="{{ asset('images/logo-plaza-meru-new.png') }}" alt="Hotel Plaza Meru">
    </div>
    <div class="">
        <div class="prifix_loading_box "> <span></span> <span></span> <span></span> <span></span>
            <span></span> <span></span> <span></span> <span></span> <span></span>
        </div>
    </div>

    <script>
        setTimeout( function() {
            window.location.href = "http://localhost:82/RegistroAsistencia/public/home";
        }, 8500 );



    </script>
</body>

</html>
