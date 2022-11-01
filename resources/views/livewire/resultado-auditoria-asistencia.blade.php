<div class="row  justify-content-md-center">
    <div class="col">
        <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">{{ $titulo }}</div>
    </div>
</div>
<div class="row  justify-content-md-center">
    <div class="col">
        @if ($optionNumber === 1 || $optionNumber === 3 || $optionNumber === 5 || $optionNumber === 7 )
            <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Desde: {{ date('d-m-Y', strtotime($fechaInicio)) }} - Hasta: {{ date('d-m-Y', strtotime($fechaFin)) }}</div>
        @else
            <div class="display-6 fs-6 fw-bold text-center py-2 " style="color: #014a97;">Fecha: {{ date('d-m-Y', strtotime($fechaInicio)) }} </div>
        @endif

    </div>
    <div class="col-md-auto">
        {{-- @if ($info != null)
           <a class="btn btn-outline-danger" href="{{ route ('impReporte')}}" target="_blank" type="button" form="formConsultar"><i class="fs-4 far fa-file-pdf fa-lg"></i></i></a>
        @endif --}}

    </div>

</div>
@if ($optionNumber === 1)
    @for ($i = 0; $i < count($resultado); $i++)
        <div class="mt-3 mb-3 mx-auto w-50 card  border border-primary border-2  shadow " >

        @for ($j = 0; $j < count($resultado[$i]); $j++)
            <div class="card-body ">
                @include('asistencia.parcial.auditoria-card-title')
                @if ($resultado[$i][$j]['Registros'] != null)
                    @for ($k = 0; $k < count($resultado[$i][$j]['Registros']); $k++)
                        @include('asistencia.parcial.auditoria-body-card')

                    @endfor
                @endif
            </div>
        @endfor

        </div>
    @endfor
@endif

@if ($optionNumber === 2)
    @for ($i = 0; $i < count($resultado); $i++)
        <div class="mt-3 mb-3 mx-auto w-50 card border border-primary border-2 shadow " >

        @for ($j = 0; $j < count($resultado[$i]); $j++)
            <div class="card-body ">
                @include('asistencia.parcial.auditoria-card-title')
                @if ($resultado[$i][$j]['Registros'] != null)
                    @for ($k = 0; $k < count($resultado[$i][$j]['Registros']); $k++)
                        @include('asistencia.parcial.auditoria-body-card')

                    @endfor
                @endif
            </div>
        @endfor
        </div>
    @endfor

@endif

@if ($optionNumber === 3 || $optionNumber === 5)

    <div class="mt-3 mb-3 mx-auto w-50 card  border border-primary border-2  shadow " >

    @for ($j = 0; $j < count($resultado); $j++)

        <div class="card-body ">
            @include('asistencia.parcial.auditoria-card-title')
            @if ($resultado[$j]['Registros'] != null)
                @for ($k = 0; $k < count($resultado[$j]['Registros']); $k++)
                    @include('asistencia.parcial.auditoria-body-card')

                @endfor
            @endif
        </div>
    @endfor

    </div>

@endif

@if ($optionNumber === 4 || $optionNumber === 6 || $optionNumber === 7 || $optionNumber === 8)

    <div class="mt-3 mb-3 mx-auto w-50 card border border-primary border-2 shadow " >
        <div class="card-body ">
            @include('asistencia.parcial.auditoria-card-title')
            @if ($resultado['Registros'] != null)
                @for ($k = 0; $k < count($resultado['Registros']); $k++)
                    @include('asistencia.parcial.auditoria-body-card')
                @endfor
            @endif
        </div>
    </div>


@endif

