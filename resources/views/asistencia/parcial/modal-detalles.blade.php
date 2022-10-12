@extends('layouts.app')

@section('content')
<div class="mt-3 mx-auto w-75 card shadow " >
    <div class="card-body ">


        <div class="card-title">
            <h5 class=" text-center fs-4">
                <span>{{$departamento}} | {{ $nombre }} | Fecha: {{ $fecha}}</span>
            </h5>
        </div>
{{-- 
        <div class="d-flex flex-column">

            @for ($i = 0; $i < $contador; $i++)

                <div class="fs-5 fw-bold text-center">

                    <div class="alert alert-light border border-dark">{{ $hora[$i] }} -  Mediante {{$poncheBio[$i]}}. </div>

                </div>
            @endfor


        </div> --}}
        <ol class="list-group list-group-numbered ">
            @for ($i = 0; $i < $contador; $i++)

                <li class="list-group-item  list-group-item-secondary">

                    <div class="fs-5 fw-bold  ">{{ $hora[$i] }} -  Mediante {{$poncheBio[$i]}}. </div>

                </li>
            @endfor

          </ol>
        <div class="modal-footer">

            <p >
                <a href="javascript:close();" role="button"  class="btn btn-secondary float-end"> Cerrar </a>
            </p>


        </div>
    </div>
</div>
@endsection



