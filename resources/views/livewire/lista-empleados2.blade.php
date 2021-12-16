<div >
    @livewire('seleccione-dia')
   
    <div class="col py-2"> 
        <div class="accordion border border-secondary rounded " style="height: 80%" id="accDepartamento" >
            @foreach ($departamentos as $dpto)
                <div class="accordion-item   ">
                <h2 class="accordion-header fw-bold fs-5" id="head-{{ $dpto->nombre }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acc-{{ $dpto->codigo }}" aria-expanded="true" aria-controls="collapse{{ $dpto->codigo }}">
                        {{ $dpto->nombre }} 
                    </button>
                </h2>
                <div id="acc-{{ $dpto->codigo }}" class="accordion-collapse collapse show" aria-labelledby="head-{{ $dpto->nombre }}" data-bs-parent="#accDepartamento">
                    <div class="accordion-body">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th scope="col" width="10%">Cédula</th>
                                    <th scope="col" width="18%">Nombres y Apellidos</th>
                                    <th scope="col" width="16%">Hora Entrada 1</th>
                                    <th scope="col" width="16%">Hora Salida 1</th>
                                    <th scope="col" width="16%">Hora Entrada 2</th>
                                    <th scope="col" width="16%">Hora Salida 2</th>
                                    <th scope="col" width="6%">Nocturno</th>
                                </tr>
                                @if ($dataControl !== 0)
                                    @for ($i = 1; $i <= count($dataControl); $i++)
                                    
                                        @if ($dataControl[$i]['departamento_id'] == $dpto->codigo)
                                            <tr>
                                                <th scope="row ">{{ $dataControl[$i]['cedula'] }} {!! Form::hidden('lasCedulas[]', $dataControl[$i]['cedula']) !!}</th>
                                                <td class=""> {{ $dataControl[$i]['nombre'] }} {!! Form::hidden('losNombres[]', $dataControl[$i]['nombre']) !!}{!! Form::hidden('losDepartamentos[]', $dpto->nombre) !!}</td>
                                            
                                                <td class=" g-0"> 
                                                    
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada'] !== NULL)
                                                            {!! Form::text('hrEntrada[]', $dataControl[$i]['HoraEntrada'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt-' . $i]) !!}    
                                                        @else
                                                            {!! Form::text('hrEntrada[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt-' . $i]) !!}    
                                                        @endif
                                                        
                                                    </div>                                                
                                                </td> 
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraSalida'] !== NULL)
                                                            {!! Form::text('hrSalida[]', $dataControl[$i]['HoraSalida'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}    
                                                        @else
                                                            {!! Form::text('hrSalida[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}    
                                                        @endif 
                                                        <div class="invalid-feedback">
                                                            La hora de salida no debe ser menor a la hora de entrada.
                                                        </div>
                                                    </div> 
                                                    
                                                    
                                                </td>

                                                <td class=" g-0"> 
                                                    
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada'] !== NULL)
                                                            {!! Form::text('hrEntrada2[]', $dataControl[$i]['HoraEntrada'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt2-' . $i]) !!}    
                                                        @else
                                                            {!! Form::text('hrEntrada2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt2-' . $i]) !!}    
                                                        @endif
                                                        
                                                    </div>                                                
                                                </td> 
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraSalida'] !== NULL)
                                                            {!! Form::text('hrSalida2[]', $dataControl[$i]['HoraSalida'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal2-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}    
                                                        @else
                                                            {!! Form::text('hrSalida2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal2-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}    
                                                        @endif 
                                                        <div class="invalid-feedback">
                                                            La hora de salida no debe ser menor a la hora de entrada.
                                                        </div>
                                                    </div> 
                                                    
                                                    
                                                </td>
                                                <td class="text-center">
                                                    {{ $dataControl[$i]['ModoEntrada'] }}
                                                  
                                                </td>
                                                
                                                
                                            </tr>
                                        @endif
                                    @endfor
                                @else
                                    @foreach ($empleados as $registro)
                                    
                                       @if ($registro->Departamento_id == $dpto->codigo)
                                            <tr>
                                                <th scope="row ">{{ $registro->cedula }} {!! Form::hidden('lasCedulas[]', $registro->cedula) !!}</th>
                                                <td class=""> {{ $registro->primer_nombre }} {{ $registro->primer_apellido }}  {!! Form::hidden('losNombres[]', $registro->primer_nombre . ' ' . $registro->primer_apellido ) !!}{!! Form::hidden('losDepartamentos[]', $dpto->nombre) !!}</td>
                                            
                                                <td class=" g-0"> 
                                                    
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        
                                                            {!! Form::text('hrEntrada1[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true' ,'id'=>'HrEnt-' . $loop->iteration]) !!}    
                                                       
                                                    </div>                                                
                                                </td> 
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        {!! Form::text('hrSalida1[]', null, ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off', 'size'=>'9', 'readonly'=>'true',  'id'=>'HrSal-' . $loop->iteration, 'onchange'=> 'HrSalNoMenorHrEnt('. $loop->iteration .')']) !!}
                                                        <div class="invalid-feedback">
                                                            La hora de salida no debe ser menor a la hora de entrada.
                                                        </div>
                                                    </div>
                                                    
                                                
                                                </td>
                                                <td class=" g-0"> 
                                                    
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        
                                                            {!! Form::text('hrEntrada2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true' ,'id'=>'HrEnt2-' . $loop->iteration]) !!}    
                                                       
                                                    </div>                                                
                                                </td> 
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        {!! Form::text('hrSalida2[]', null, ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off', 'size'=>'9', 'readonly'=>'true',  'id'=>'HrSal2-' . $loop->iteration, 'onchange'=> 'HrSalNoMenorHrEnt('. $loop->iteration .')']) !!}
                                                        <div class="invalid-feedback">
                                                            La hora de salida no debe ser menor a la hora de entrada.
                                                        </div>
                                                    </div>
                                                    
                                                
                                                </td>
                                                <td class="text-center">
                                                     
                                                </td>
                                                
                                                
                                            </tr>
                                        @endif 
                                    @endforeach
                                @endif
                                
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
            
            
        </div>
            

    </div> 
    
    
    
</div>
