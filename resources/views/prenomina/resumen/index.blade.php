@extends('layouts.app')

@section('content')
    <div class="row row-cols-3 align-items-center mt-2 ">
        <div class="col  ">
            <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png') }}" width="33%" height="50%">
        </div>
        <div class="col ">
            <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Resumen</div>
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
    @livewire('prenomina.resumen.mostrar-resumen')
    <hr class="dropdown-divider">
    @livewire('prenomina.resumen.mostrar-resultado-resumen')


    @endsection

@section('CustomsJS')
<script>
    $(document).ready(function() {

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

                var time = setTimeout(function() {
                    startTime()
                }, 500);
            }

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }

        });

        $.get('departamentos', function(resp) {
            $('#selDepartamento').append('<option value="">-- Seleccione --</option>');
            for (i = 0; i < resp.length; i++) {
                $('#selDepartamento').append('<option value="' + resp[i].codigo + '">' + resp[i]
                    .nombre + '</option>');
            }
        });

</script>
@endsection
