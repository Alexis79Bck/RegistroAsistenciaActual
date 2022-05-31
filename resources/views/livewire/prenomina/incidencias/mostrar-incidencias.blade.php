@extends('layouts.app')

@section('content')
    <div>
        <div class="row row-cols-3 align-items-center mt-2 ">
            <div class="col  ">
                <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png') }}" width="33%" height="50%">
            </div>
            <div class="col ">
                <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Incidencias -
                    {{ $departamento->nombre }}</div>
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
        <div class="card text-center shadow mb-5">

            <div class="card-body">
                <div class="accordion" id="accordionEmpleado">
                    @foreach ($empleados as $empleado)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ $empleado->cedula }} ">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $empleado->cedula }}" aria-expanded="true"
                                    aria-controls="collapse{{ $empleado->cedula }}">
                                    {{ $empleado->primer_nombre }} {{ $empleado->primer_apellido }}
                                </button>
                            </h2>
                            <div id="collapse{{ $empleado->cedula }}" class="accordion-collapse collapse "
                                aria-labelledby="{{ $empleado->cedula }}" data-bs-parent="#accordionEmpleado">
                                <div class="accordion-body">
                                    <div class="alert alert-success" role="alert">
                                        LISTADO DE INCIDENCIA DE {{ $empleado->primer_nombre }}
                                        {{ $empleado->primer_apellido }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>


    </div>
@endsection
