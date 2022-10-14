
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/local/normalize.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" >


    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontsawesome/all.min.css') }}">
</head>
<body>
    <div class="mt-3 mx-auto w-75 card border border-primary border-2 rounded shadow " >
        <div class="card-body ">


            <div class="card-title">
                <h5 class=" text-center fs-4">
                    <span>{{$departamento}} | {{ $nombre }} | Fecha: {{ $fecha}}</span>
                </h5>
            </div>

            <ol class="list-group list-group-numbered ">
                @for ($i = 0; $i < $contador; $i++)

                    <li class="list-group-item  list-group-item-secondary">

                        <div class="fs-5 fw-bold  ">{{ $hora[$i] }} -  Mediante {{$poncheBio[$i]}}. </div>

                    </li>
                @endfor

              </ol>
            <div class="modal-footer">

                <p >
                    <a href="javascript:close();" role="button"  class="btn btn-secondary float-end"> Cerrar </a>
                </p>


            </div>
        </div>
    </div>


    <script src="{!! asset('js/bootstrap/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('js/jquery/moment.min.js') !!}"></script>
    <script src="{!! asset('js/jquery/jquery-3.5.1.min.js') !!}"></script>
    <script src="{!! asset('js/jquery/jquery-ui.min.js') !!}"></script>
</body>
</html>




