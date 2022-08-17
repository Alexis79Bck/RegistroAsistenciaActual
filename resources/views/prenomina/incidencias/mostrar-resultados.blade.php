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
        <div class="fs-4 fw-bold text-center " style="color: #014a97;">{{session('nombre_departamento')}}</div>
    </div>
    <div class="col">
        <p></p>
    </div>
</div>
<hr class="dropdown-divider">
<div class="card  shadow mb-5">

    <div class="card-body ">
        <div class="accordion " id="accordionEmpleado">
            @for ($j = 0; $j < count($listaEmpleados); $j++) <div class="accordion-item">

                <h2 class="accordion-header" id="{{ $listaEmpleados[$j]['cedula'] }} ">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $listaEmpleados[$j]['cedula'] }}" aria-expanded="true"
                        aria-controls="collapse{{ $listaEmpleados[$j]['cedula'] }}">
                        {{ $listaEmpleados[$j]['nombre'] }}
                    </button>
                </h2>
                <div id="collapse{{ $listaEmpleados[$j]['cedula'] }}" class="accordion-collapse collapse "
                    aria-labelledby="{{ $listaEmpleados[$j]['cedula'] }}" data-bs-parent="#accordionEmpleado">
                    <div class="accordion-body">
                        {!! Form::hidden('listaCedulaEmpleados[' . $j . ']', $listaEmpleados[$j]['cedula'])
                        !!}
                        {!! Form::hidden('contIncidencia[' . $j . ']', $listaEmpleados[$j]['contIncidencia'])
                        !!}
                        <div class="container">
                            <div class="col justify-content-center">

                                @if ($listaEmpleados[$j]['contIncidencia'] == 0)
                                <div class="alert  "
                                    style='-moz-box-shadow: 1px 1px 3px 2px ; -webkit-box-shadow: 1px 1px 3px 2px; box-shadow: 1px 1px 3px 2px;'>


                                    <p>No registra incidencia. </p>

                                </div>
                                @else
                                {{-- {!! Form::hidden('listaFecha[' . $i . ']', $listaFechas[$i]) !!} --}}
                                @for ($i = 0; $i < count($listaFechas); $i++)
                                    {{-- @if ($resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['HayIncidencia']) --}}
                                        {{-- {!! Form::open(['route'=>'guardar_incidencias','class'=>'form']) !!} --}}

                                                {{-- <div class="alert "
                                                    style='-moz-box-shadow: 1px 1px 3px 2px {{ $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['ColorIncidencia'] }}; -webkit-box-shadow: 1px 1px 3px 2px {{ $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['ColorIncidencia'] }};  box-shadow: 1px 1px 3px 2px {{$resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['ColorIncidencia'] }};'>
                                                    <p class="fs-5">Día:  {{ date('d-m-Y', strtotime($listaFechas[$i])) }}
                                                        <br>

                                                        @if ($resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['Mensaje'] != null)
                                                        <span>
                                                            ---
                                                            {{ $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['Mensaje'] }}
                                                            {!! Form::hidden('Mensaje',  $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['Mensaje']) !!}
                                                        </span><br>
                                                        @endif
                                                        @if ($resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeEntrada'] != null)
                                                        <span>
                                                            ---
                                                            {{ $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeEntrada'] }}
                                                            {!! Form::hidden('MensajeEntrada', $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeEntrada']) !!}
                                                        </span><br>
                                                        @endif
                                                        @if ($resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeSalida'] != null)
                                                        <span>
                                                            ---
                                                            {{ $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeSalida'] }}
                                                            {!! Form::hidden('MensajeSalida', $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]]['MensajeSalida']) !!}
                                                        </span><br>
                                                        @endif

                                                        {!! Form::label('observacion', 'Observación:', ['class' => 'form-label']) !!}
                                                        {!! Form::textarea('observacion[' . $listaEmpleados[$j]['cedula'] . '][' . $listaFechas[$i] . ']', null, ['class' => 'w-100 form-control', 'rows' => '3']) !!}

                                                    </p>
                                                    <div class="d-flex flex-row-reverse ">
                                                            {{-- @livewire('prenomina.incidencias.boton-guardar-incidencias',['resultado'=> $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]],'cedula'=> $listaEmpleados[$j]['cedula'], 'fecha'=> $listaFechas[$i]], key($listaEmpleados[$j]['cedula'])) -}}

                                                            {!! Form::hidden('fecha', $listaFechas[$i]) !!}
                                                            {!! Form::hidden('cedula', $listaEmpleados[$j]['cedula']) !!}
                                                            <button class="btn btn-success " type="submit" >Guardar</a>
                                                        </div>
                                                </div> --}}
                                        {{-- {!! Form::close() !!} --}}
                                    {{-- @endif --}}
                                    @livewire('prenomina.incidencias.cuadro-mensaje-incidencia', ['data'=>$resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]],'fecha'=>$listaFechas[$i],'cedula'=>$listaEmpleados[$j]['cedula']], key($listaEmpleados[$j]['cedula'] . '-'.$listaFechas[$i]))
                                @endfor
                            @endif

                        </div>
                    </div>

                </div>
        </div>
    </div>
    @endfor

</div>

</div>
{{-- <div class="card-footer">
    {{-- @livewire('prenomina.incidencias.boton-guardar-incidencias')
    <button class="btn btn-success float-end" type="submit">Guardar</button>
</div> --}}


</div>
{{-- {!! Form::close() !!} --}}


</div>


@endsection
