@extends('layouts.app')

@section('content')
    <div>
        <div class="row row-cols-3 align-items-center mt-2 ">
            <div class="col  ">
                <img class="img-fluid " src="{{ asset('images/titulo-plaza-meru.png') }}" width="33%" height="50%">
            </div>
            <div class="col ">
                <div class="fs-5 fw-bold text-center py-2 " style="color: #014a97;">Incidencias -
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
                    @for ($j = 0; $j < count($listaCedulaEmpleados); $j++)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ $listaCedulaEmpleados[$j]['cedula'] }} ">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $listaCedulaEmpleados[$j]['cedula'] }}"
                                    aria-expanded="true"
                                    aria-controls="collapse{{ $listaCedulaEmpleados[$j]['cedula'] }}">
                                    {{ $listaCedulaEmpleados[$j]['nombre'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $listaCedulaEmpleados[$j]['cedula'] }}"
                                class="accordion-collapse collapse "
                                aria-labelledby="{{ $listaCedulaEmpleados[$j]['cedula'] }}"
                                data-bs-parent="#accordionEmpleado">
                                <div class="accordion-body">
                                    @if ($listaCedulaEmpleados[$j]['contIncidencia'] == 0)
                                        <div class="alert"
                                            style='-moz-box-shadow: 1px 1px 3px 2px ; -webkit-box-shadow: 1px 1px 3px 2px; box-shadow: 1px 1px 3px 2px;'>


                                            <p>No registra incidencia. </p>



                                        </div>
                                    @else
                                        @for ($i = 0; $i < count($listaFechas); $i++)
                                            @if ($resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['HayIncidencia'] == true)
                                                <div class="alert"
                                                    style='-moz-box-shadow: 1px 1px 3px 2px {{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['ColorIncidencia'] }}; -webkit-box-shadow: 1px 1px 3px 2px {{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['ColorIncidencia'] }}; box-shadow: 1px 1px 3px 2px {{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['ColorIncidencia'] }};'>
                                                    <span
                                                        class="fs-5">{{ date('d-m-Y', strtotime($listaFechas[$i])) }}</span>

                                                    <p>{{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['Mensaje'] }}
                                                    </p>
                                                    <p>{{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['MensajeEntrada'] }}
                                                    </p>
                                                    <p>{{ $resultadoEmpleadoHorario[$listaFechas[$i]][$listaCedulaEmpleados[$j]['cedula']]['MensajeSalida'] }}
                                                    </p>



                                                </div>
                                            @endif
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>

            </div>
            <div class="card-footer">
                Card footer
            </div>


        </div>


    </div>
@endsection
