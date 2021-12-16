@extends('layouts.reporte')

@section('content')
    @foreach ($departamentos as $departamento)
    @if ($ctReg[$loop->iteration - 1] > 0) 
        <table width="100%" border="1" style="margin-bottom: 0.75rem; border:#003160 solid 2px; border-collapse: collapse; text-align: center; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9rem; padding-bottom:inherit">
        
            <tr >
              <td colspan="7" class="bg-light text-primary  fw-bold text-center" style="font-size:1.1rem;">
                <span > {{ $departamento->nombre}}   </span>
              </td>
            </tr> 
            <tr class="bg-primary text-light  fw-bold text-center">
              <td style="border:#003160 solid 1px; ">Fecha</td>
              <td style="border:#003160 solid 1px; ">Nombre y Apellido</td>
              <td style="border:#003160 solid 1px; ">Cédula</td> 
              <td  style="border:#003160 solid 1px; ">Hora Entrada</td>
              <td style="border:#003160 solid 1px; ">Hora Salida</td>
              <td style="border:#003160 solid 1px; ">Modo Entrada</td>
              <td  style="border:#003160 solid 1px; ">Total Horas</td> 
            </tr> 
            @for ($i = 0; $i < count($data[$loop->iteration - 1]); $i++)
                @if ($departamento->nombre == $data[$loop->iteration - 1][$i]['departamento'])
                    <tr class="text-center">
                      <td data-label="Fecha" style="border:#003160 solid 1px; ">{{$data[$loop->iteration - 1][$i]['fecha']}}</td>
                      <td data-label="Nombre y Apellido" style="border:#003160 solid 1px; ">{{$data[$loop->iteration - 1][$i]['nombre']}}</td>
                      <td data-label="Cédula" style="border:#003160 solid 1px; ">{{$data[$loop->iteration - 1][$i]['cedula']}}</td>
                      <td data-label="Hora Entrada" style="border:#003160 solid 1px; ">
                        @if ($data[$loop->iteration - 1][$i]['horaEnt'] == null)
                            <span class="text-danger">Empleado no registró entrada</span>
                        @else
                            {{ $data[$loop->iteration - 1][$i]['horaEnt']}}
                        @endif
                        @if ($data[$loop->iteration - 1][$i]['horaEnt2'] != null)
                            <br>
                            {{ $data[$loop->iteration - 1][$i]['horaEnt2']}}
                        @endif
                      </td>
                      <td data-label="Hora Salida" style="border:#003160 solid 1px; ">
                        @if ($data[$loop->iteration - 1][$i]['horaSal'] == null)
                            <span class="text-danger">Empleado no registró salida</span>
                        @else
                            {{$data[$loop->iteration - 1][$i]['horaSal']}}
                        @endif
                         @if ($data[$loop->iteration - 1][$i]['horaSal2'] != null)
                            <br>
                            {{$data[$loop->iteration - 1][$i]['horaSal2']}}
                        @endif
                      </td>

                      <td data-label="Modo Entrada" style="border:#003160 solid 1px; ">
                            
                        <span class="text-danger text-center">{{$data[$loop->iteration - 1][$i]['Modo']}}</span>
                    
                      </td>

                      <td data-label="Total Horas" style="border:#003160 solid 1px; ">
                        @if ($data[$loop->iteration - 1][$i]['horaSal'] == null)
                            <span class="text-danger">Calculo no disponible</span>
                        @else
                            {{$data[$loop->iteration - 1][$i]['totalHoras']}}
                        @endif
                        
                      </td>
                  </tr>
                  
                @endif
            
            @endfor 
        </table>
        {{-- @if ($loop->iteration == 5)
            <div class="page-break"></div>
        @endif --}}
        @endif
    @endforeach
@endsection