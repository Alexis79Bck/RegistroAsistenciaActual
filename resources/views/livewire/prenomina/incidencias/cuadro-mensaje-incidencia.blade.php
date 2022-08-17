<div>

        @if ($resultado['HayIncidencia'] && $checkGuardar == false)

            <div class="alert "
                style='-moz-box-shadow: 1px 1px 3px 2px {{ $resultado['ColorIncidencia'] }}; -webkit-box-shadow: 1px 1px 3px 2px {{ $resultado['ColorIncidencia'] }};  box-shadow: 1px 1px 3px 2px {{$resultado['ColorIncidencia'] }};'>
                <p class="fs-5">Día:  {{ date('d-m-Y', strtotime($fecha)) }}
                    <br>

                    @if ($resultado['Mensaje'] != null)
                    <span>
                        ---
                        {{ $resultado['Mensaje'] }}
                        {!! Form::hidden('Mensaje',  $resultado['Mensaje']) !!}
                    </span><br>
                    @endif
                    @if ($resultado['MensajeEntrada'] != null)
                    <span>
                        ---
                        {{ $resultado['MensajeEntrada'] }}
                        {!! Form::hidden('MensajeEntrada', $resultado['MensajeEntrada']) !!}
                    </span><br>
                    @endif
                    @if ($resultado['MensajeSalida'] != null)
                    <span>
                        ---
                        {{ $resultado['MensajeSalida'] }}
                        {!! Form::hidden('MensajeSalida', $resultado['MensajeSalida']) !!}
                    </span><br>
                    @endif

                    {!! Form::label('observacion', 'Observación:', ['class' => 'form-label']) !!}
                    {!! Form::textarea('observacion[' . $cedula . '][' . $fecha . ']', null, ['class' => 'w-100 form-control', 'rows' => '3','wire:model'=>'observacion']) !!}

                </p>
                <div class="d-flex flex-row-reverse ">


                        {!! Form::hidden('fecha', $fecha) !!}
                        {!! Form::hidden('cedula', $cedula) !!}

                        <button class="btn btn-success " type="button"   wire:click="Guardar()">Guardar</a>
                    </div>
            </div>
        @endif
        @if ($checkGuardar && $resultado['HayIncidencia'] )
            <div class="alert alert-info alert-dimissible fade show" >
                <span class="fs-5">Incidencia del Día: <b class="fw-bolder h4">{{ date('d-m-Y', strtotime($fecha)) }}</b> ha sido guardada.</span>
                <button type="button" class="btn-close fw-bolder float-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        @endif


</div>
