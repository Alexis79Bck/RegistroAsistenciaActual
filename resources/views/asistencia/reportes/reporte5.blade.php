@extends('layouts.reporte')

@section('content') 
        <table width="100%" border="1" style="margin-bottom: 0.75rem; border:#003160 solid 2px; border-collapse: collapse; text-align: center; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9rem; padding-bottom:inherit">
         
            <tr class="bg-primary text-light  fw-bold text-center">
              <td style="border:#003160 solid 1px; ">Fecha</td>
              <td  style="border:#003160 solid 1px; ">Hora Entrada</td>
              <td style="border:#003160 solid 1px; ">Hora Salida</td>
              <td style="border:#003160 solid 1px; ">Modo Entrada</td>
              <td  style="border:#003160 solid 1px; ">Total Horas</td> 
            </tr> 
            @for ($i = 0; $i < count($data); $i++)
                    <tr class="text-center">
                      <td data-label="Fecha" style="border:#003160 solid 1px; ">{{$data[$i]['fecha']}}</td>
                      <td data-label="Hora Entrada" style="border:#003160 solid 1px; ">
                        @if ($data[$i]['horaEnt'] == null)
                            <span class="text-danger">Empleado no registró entrada</span>
                        @else
                            {{ $data[$i]['horaEnt']}}
                        @endif
                         @if ($data[$i]['horaEnt2'] != null)
                            <br>
                            {{ $data[$i]['horaEnt2']}}
                        @endif
                        
                      </td>
                      <td data-label="Hora Salida" style="border:#003160 solid 1px; ">
                        @if ($data[$i]['horaSal'] == null)
                            <span class="text-danger">Empleado no registró salida</span>
                        @else
                            {{$data[$i]['horaSal']}}
                        @endif
                        @if ($data[$i]['horaSal2'] != null)
                            <br>
                            {{$data[$i]['horaSal2']}}
                        @endif
                       
                      </td>

                      <td data-label="Modo Entrada" style="border:#003160 solid 1px; ">
                            
                        <span class="text-danger text-center">{{$data[$i]['Modo']}}</span>
                    
                      </td>

                      <td data-label="Total Horas" style="border:#003160 solid 1px; ">
                        @if ($data[$i]['horaSal'] == null)
                            <span class="text-danger">Calculo no disponible</span>
                        @else
                            {{$data[$i]['totalHoras']}}
                        @endif
                        
                        
                      </td>
                  </tr> 
            @endfor 
        </table> 
    
@endsection