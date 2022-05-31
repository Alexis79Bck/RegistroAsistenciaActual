@extends('layouts.app')

@section('content')
    <div class="row row-cols-3 align-items-center mt-2 ">
        <div class="col  ">
            <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png') }}" width="33%" height="50%">
        </div>
        <div class="col ">
            <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Incidencias</div>
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

    {!! Form::open(['route' => 'mostrar_incidencias', 'class' => 'g-1 align-items-center', 'id' => 'formConsultar']) !!}
    <div class="row mb-2">
        <div class="col">
            <div class="form-check">
                {!! Form::label('Departamento', 'Departamento', ['class' => 'form-check-label']) !!}
            </div>
            <div class=" form-group" id="grupoDepartamentos">
                <select name="departamento" id="selDepartamento" class="form-select form-select-sm"></select>
            </div>

        </div>
        <div class="col">
            {!! Form::label('fechaInicio', 'Rango de Fecha:', ['class' => 'form-check-label float-end']) !!}
        </div>

        <div class="col">

            <div class=" form-group">
                <div class="input-group input-group-sm mb-1 " id="grupoFechaInicio">
                    <span class="input-group-text bg-primary text-white fw-bold">Desde:</span>
                    {!! Form::date('fechaInicio', date('Y-m-d'), ['class' => 'form-control ', 'id' => 'ctrlFechaInicio', 'min' => date('Y-m-d', strtotime($minFijadoFechaInicio->toDateString())), 'max' => date('Y-m-d', strtotime($maxFijadoFechaInicio->toDateString()))]) !!}

                </div>
            </div>
        </div>
        <div class="col">
            <div class=" form-group">
                <div class="input-group input-group-sm mb-1 " id="grupoFechaFin">
                    <span class="input-group-text bg-primary text-white fw-bold">Hasta:</span>
                    {!! Form::date('fechaFin', date('Y-m-d'), ['class' => 'form-control', 'id' => 'ctrlFechaFin', 'min' => date('Y-m-d', strtotime($minFijadoFechaInicio->toDateString())), 'max' => date('Y-m-d', strtotime($maxFijadoFechaInicio->toDateString()))]) !!}
                </div>
            </div>
        </div>
        <div class="col">
            <button class="btn btn-sm btn-success" type="submit" value="consultar"><i class="fas fa-search text-light"></i>
                Mostrar</button>
        </div>



    </div>
    {!! Form::close() !!}

    <hr class="dropdown-divider">
    {{-- @livewire('prenomina.incidencias.mostrar-incidencias', ['empleados' => $empleados], key($user->id)) --}}
@endsection

@section('CustomsJS')
    <script>
        $(document).ready(function() {

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

        // $('#consultaHoy').change(function(e) {

        //     e.preventDefault();
        //     if (this.checked) {
        //         $('#ctrlFechaFin').attr('disabled', true);
        //         // $('#ctrlFechaFin').hide();
        //     } else {
        //         $('#ctrlFechaFin').removeAttr('disabled');
        //         // $('#ctrlFechaFin').show();
        //     }
        // });

        // $('#Departamento').on('change', function(e) {
        //     e.preventDefault();
        //     if (this.checked) {
        //         $('#grupoDepartamentos').show();
        //         $('#grupoEmpleadosDepartamento').hide();
        //         $('#cedula').hide();
        //         $('#selDepartamento').empty();
        $.get('departamentos', function(resp) {
            $('#selDepartamento').append('<option value="Todos">-- Seleccione --</option>');
            for (i = 0; i < resp.length; i++) {
                $('#selDepartamento').append('<option value="' + resp[i].codigo + '">' + resp[i]
                    .nombre + '</option>');
            }
        });

        //     } else {
        //         $('#grupoDepartamentos').hide();
        //         $('#grupoEmpleadosDepartamento').hide();
        //         $('#cedula').show();
        //         $('#selDepartamento').empty();
        //         $('#selEmpleadoDepartamento').empty();

        //     }
        // });

        // $('#selDepartamento').on('change', function(e) {
        //     e.preventDefault();
        //     $('#grupoEmpleadosDepartamento').show();
        //     //$('#grupoEmpleadosDepartamento').empty();
        //     $('#selEmpleadoDepartamento').empty();
        //     codigo = $('#selDepartamento').val();
        //     $.get('departamento-' + codigo + '/empleados', function(resp) {

        //         $('#selEmpleadoDepartamento').append('<option value="Todos">Todos</option>');
        //         for (i = 0; i < resp.length; i++) {

        //             $('#selEmpleadoDepartamento').append('<option value="' + resp[i].cedula + '">' + resp[i]
        //                 .primer_nombre + ' ' + resp[i].primer_apellido + '</option>');
        //         }
        //     })
        // });

        // $('#consultaPorCedula').on('change', function(e) {
        //     e.preventDefault();
        //     if (this.checked) {
        //         $('#grupoDepartamentos').hide();
        //         $('#grupoEmpleadosDepartamento').hide();
        //         $('#cedula').show();

        //     } else {
        //         $('#grupoDepartamentos').show();
        //         $('#cedula').hide();


        //     }
        // });

        // function soloNumeros(e) {
        //     var key = window.Event ? e.which : e.keyCode
        //     return ((key >= 48 && key <= 57) || (key == 8))
        // }
    </script>
@endsection
