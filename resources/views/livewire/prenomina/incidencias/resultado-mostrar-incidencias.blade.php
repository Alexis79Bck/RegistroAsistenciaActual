
<div>

        <div class="card  shadow mb-5">

            <div class="card-body ">
                <div class="accordion " id="accordionEmpleado">
                    @for ($j = 0; $j < $totalEmpleados; $j++) <div class="accordion-item">

                        <h2 class="accordion-header" id="{{ $listaEmpleados[$j]['cedula'] }} ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $listaEmpleados[$j]['cedula'] }}" aria-expanded="true"> {{
                                $listaEmpleados[$j]['nombre'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $listaEmpleados[$j]['cedula'] }}" class="accordion-collapse collapse "
                            aria-labelledby="{{ $listaEmpleados[$j]['cedula'] }}" data-bs-parent="#accordionEmpleado">
                            <div class="accordion-body">
                                {!! Form::hidden('listaEmpleados[' . $j . ']', $listaEmpleados[$j]['cedula']) !!}
                                {!! Form::hidden('contIncidencia[' . $j . ']', $listaEmpleados[$j]['contIncidencia']) !!}
                                <div class="container">
                                    <div class="col justify-content-center">

                                        @if ($listaEmpleados[$j]['contIncidencia'] == 0)
                                        <div class="alert  "
                                            style='-moz-box-shadow: 1px 1px 3px 2px ; -webkit-box-shadow: 1px 1px 3px 2px; box-shadow: 1px 1px 3px 2px;'>
                                            <p>No registra incidencia. </p>
                                        </div>
                                        @else
                                        @for ($i = 0; $i < $cantidadFechas; $i++)
                                            @livewire('prenomina.incidencias.cuadro-mensaje-incidencia', ['data'=>
                                            $resultadoEmpleadoHorario[$listaEmpleados[$j]['cedula']][$listaFechas[$i]],'fecha'
                                            => $listaFechas[$i],'cedula'=>$listaEmpleados[$j]['cedula']], key($listaEmpleados[$j]['cedula'] .'-'.$listaFechas[$i]))
                                            @endfor
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                </div>
            </div>
        </div>

</div>


