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
                                    <th scope="col" width="16%">Hora Entrada</th>
                                    <th scope="col" width="16%" colspan="2">Hora Salida</th>
                                    <th scope="col" width="6%">Nocturno</th>
                                    <th scope="col" width="6%">Modo de Entrada</th>
                                </tr>
                                @if ($dataControl !== 0)
                                    @for ($i = 1; $i <= count($dataControl); $i++)

                                        @if ($dataControl[$i]['departamento_id'] == $dpto->codigo)
                                            <tr>
                                                <th scope="row ">{{ $dataControl[$i]['cedula'] }} {!! Form::hidden('lasCedulas[]', $dataControl[$i]['cedula']) !!}</th>
                                                <td class=""> {{ $dataControl[$i]['nombre'] }} {!! Form::hidden('losNombres[]', $dataControl[$i]['nombre']) !!}{!! Form::hidden('losDepartamentos[]', $dpto->nombre) !!}</td>

                                                <td class=" g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada'] != NULL)
                                                            {!! Form::text('hrEntrada[]', $dataControl[$i]['HoraEntrada'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt-' . $i]) !!}
                                                        @else
                                                            {!! Form::text('hrEntrada[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt-' . $i]) !!}
                                                        @endif

                                                    </div>
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " id="grupoEnt2-{{$i}}" style="{{ $dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada2'] != NULL ? '' : 'display: none'}} ">

                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada2'] != NULL)
                                                            {!! Form::text('hrEntrada2[]', $dataControl[$i]['HoraEntrada2'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt2-' . $i,'onchange'=> 'HrEnt2NoMenorHrSal('. $i .')']) !!}
                                                        @else
                                                            {!! Form::text('hrEntrada2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrEnt2-' . $i, 'onchange'=> 'HrEnt2NoMenorHrSal('. $i .')']) !!}
                                                        @endif
                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraSalida'] != NULL)
                                                            {!! Form::text('hrSalida[]', $dataControl[$i]['HoraSalida'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}
                                                        @else
                                                            {!! Form::text('hrSalida[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal-' . $i, 'onchange'=> 'HrSalNoMenorHrEnt('. $i .')']) !!}
                                                        @endif
                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " id="grupoSal2-{{$i}}" style="{{$dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada2'] != NULL ? '' : 'display: none'}}">

                                                        @if ($dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraSalida2'] != NULL)
                                                            {!! Form::text('hrSalida2[]', $dataControl[$i]['HoraSalida2'] , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal2-' . $i, 'onchange'=> 'HrSal2NoMenorHrEnt2('. $i .')']) !!}
                                                        @else
                                                            {!! Form::text('hrSalida2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true','id'=>'HrSal2-' . $i, 'onchange'=> 'HrSal2NoMenorHrEnt2('. $i .')']) !!}
                                                        @endif
                                                        <div class="invalid-feedback">
                                                        </div>

                                                    </div>

                                                </td>
                                                <td class="g-0">
                                                    <a role="button" class="btn text-success btn-sm" onclick="NuevoHrEntHrSal({{$i}})">
                                                        <i class="{{$dataControl[$i]['pinta'] == 1 && $dataControl[$i]['HoraEntrada2'] != NULL ? 'fas fa-minus-circle' : 'fas fa-plus-circle'}}" id="agregarEntSal-{{$i}}"></i>

                                                    </a>
                                                    <input type="hidden" id="chkAgregarEntSal-{{$i}}" name="chkAgregarEntSal[]" value="{{$dataControl[$i]['HoraEntrada2'] != NULL ? 'activo' : 'inactivo'}}">
                                                </td>
                                                <td class="g-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"  {{$dataControl[$i]['Nocturno'] ? 'checked' : ''}}>

                                                    </div>
                                                    <input type="hidden" id="chkNocturno-{{$i}}" name="chkNocturno[]" value="{{$dataControl[$i]['Nocturno'] ? 'Nocturno' : null}}">


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

                                                            {!! Form::text('hrEntrada[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true' ,'id'=>'HrEnt-' . $loop->iteration]) !!}

                                                    </div>
                                                     <div class="input-group input-group-sm input-group-addon  mb-1 date " id="grupoEnt2-{{$loop->iteration}}" style="display: none">

                                                            {!! Form::text('hrEntrada2[]', null , ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off','size'=>'9', 'readonly'=>'true' ,'id'=>'HrEnt2-' . $loop->iteration,'onchange'=> 'HrEnt2NoMenorHrSal('. $loop->iteration .')']) !!}
                                                            <div class="invalid-feedback">
                                                            </div>
                                                    </div>
                                                </td>
                                                <td class="g-0">

                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " >
                                                        {!! Form::text('hrSalida[]', null, ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off', 'size'=>'9', 'readonly'=>'true',  'id'=>'HrSal-' . $loop->iteration, 'onchange'=> 'HrSalNoMenorHrEnt('. $loop->iteration .')']) !!}
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="input-group input-group-sm input-group-addon  mb-1 date " id="grupoSal2-{{$loop->iteration}}" style="display: none">
                                                        {!! Form::text('hrSalida2[]', null, ['class'=>'form-control from-control-sm inpEntrada','autocomplete'=>'off', 'size'=>'9', 'readonly'=>'true',  'id'=>'HrSal2-' . $loop->iteration, 'onchange'=> 'HrSal2NoMenorHrEnt2('. $loop->iteration .')']) !!}
                                                        <div class="invalid-feedback">
                                                        </div>

                                                </td>
                                                <td class="g-0">
                                                    <a role="button" class="btn text-success btn-sm"  onclick="NuevoHrEntHrSal({{$loop->iteration}})"><i class="fas fa-plus-circle" id="agregarEntSal-{{$loop->iteration}}"></i></a>

                                                    <input type="hidden" id="chkAgregarEntSal-{{$loop->iteration}}" name="chkAgregarEntSal[]" value="inactivo">
                                                </td>

                                                <td class="g-0">
                                                    <div class="custom-control custom-checkbox text-center">
                                                        <input type="checkbox" class="custom-control-input " id="chkNocturno-{{$loop->iteration}}">

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
