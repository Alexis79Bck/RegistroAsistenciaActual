<div>
    @if ($mostrar)


    <div class="card  shadow mb-5">
        <div class="card-body ">
        <span class="d-block p-2 text-primary fs-2 display-3 text-center">Desde {{ $periodo['desde'] }} hasta {{ $periodo['hasta'] }}</span>
        @if ($contSubdeptos > 0)

            @for ($k=0; $k < $contSubdeptos; $k++)
                <table class="mb-3 table table-bordered border-primary shadow" style="border: 3px solid; border-collapse: collapse">


                        <thead class="table-primary border-primary" style="border: 3px solid; border-collapse: collapse">
                            <tr  >
                            <th class="py-1 text-dark fs-2 display-3 text-center" colspan=8> {{ $nombreSubdepto[$k]}} </th>
                            </tr>
                            <tr class="h5 text-dark fw-bolder">
                                <th class="text-center">Cédula</th>
                                <th class="text-center">Nombre Completo</th>
                                <th class="text-center">Días totales</th>
                                <th class="text-center">Días trabajado</th>
                                <th class="text-center">Feriado trabajado</th>
                                <th class="text-center">Domingo trabajado</th>
                                <th class="text-center">Días Turno Mixto</th>
                                <th class="text-center">Días Turno Nocturno</th>
                            </tr>
                        </thead>
                        @if ($tieneEmpleado[$k])
                            @for ($j=0; $j < $contEmpleados[$k]; $j++)
                                <tbody>
                                    <tr>
                                        <td class=" text-dark fw-bolder">{{$listaCedulas[$k][$j]}}</td>
                                        <td class=" text-dark fw-bolder">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['nombreCompleto']}}</td>
                                        <td class=" text-dark ">{{$contFechas}}</td>
                                        <td class=" text-dark ">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['diasTrab']}}</td>
                                        <td class=" text-dark ">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['feriadoTrab']}}</td>
                                        <td class=" text-dark ">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['domingoTrab']}}</td>
                                        <td class=" text-dark ">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['diasTurnoMx']}}</td>
                                        <td class=" text-dark ">{{$data[$nombreSubdepto[$k]][$listaCedulas[$k][$j]]['diasTurnoNoc']}}</td>
                                    </tr>
                                </tbody>
                            @endfor
                        @else
                                <tbody>
                                    <tr>
                                        <td class="py-1 text-dark fs-3 h4 text-center" colspan=8> No hay información. </td>
                                    </tr>
                                </tbody>
                        @endif

                </table>
                @endfor
            @else
               <table class="mb-3 table table-bordered border-primary shadow" style="border: 3px solid; border-collapse: collapse">

                    <thead class="table-primary border-primary" style="border: 3px solid; border-collapse: collapse">
                        <tr >
                            <th class="py-1 text-dark fs-2 display-3 text-center" colspan=8> {{ $nombreDepartamento }} </th>
                        </tr>
                        <tr class="h5 text-dark fw-bolder">
                            <th class="text-center">Cédula</th>
                            <th class="text-center">Nombre Completo</th>
                            <th class="text-center">Días totales</th>
                            <th class="text-center">Días trabajado</th>
                            <th class="text-center">Feriado trabajado</th>
                            <th class="text-center">Domingo trabajado</th>
                            <th class="text-center">Días Turno Mixto</th>
                            <th class="text-center">Días Turno Nocturno</th>
                        </tr>
                    </thead>

                    @for ($j=0; $j < $contEmpleados[0]; $j++)
                        <tbody>
                            <tr>
                                <td class=" text-dark fw-bolder">{{$listaCedulas[$j]}}</td>
                                <td class=" text-dark fw-bolder">{{$data[$j]['nombreCompleto']}}</td>
                                <td class=" text-dark ">{{$contFechas}}</td>
                                <td class=" text-dark ">{{$data[$j]['diasTrab']}}</td>
                                <td class=" text-dark ">{{$data[$j]['feriadoTrab']}}</td>
                                <td class=" text-dark ">{{$data[$j]['domingoTrab']}}</td>
                                <td class=" text-dark ">{{$data[$j]['diasTurnoMx']}}</td>
                                <td class=" text-dark ">{{$data[$j]['diasTurnoNoc']}}</td>
                            </tr>
                        </tbody>
                    @endfor
                </table>

            @endif
        </div>
    </div>
    @endif
</div>
