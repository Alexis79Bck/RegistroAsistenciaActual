@extends('layouts.app')

@section('content')
<div>
    <div class="col">
        <a href="#" class="btn btn-sm btn-secondary">Volver</a>
    </div>
    <div class="col">
        <h5 class="title text-center">
            <span>Nombre Departamento</span> | {{ $nombre }}
        </h5>
    </div>

    <h6 class="text-center text-warning" wire:loading> ... Espere un momento ...</h6>

    <div class="table-responsive">
        <table class=" shadow table table-bordered border-dark">
            <thead>
                <tr class="bg-primary text-light  fw-bold text-center">

                    <th colspan="8">
                    <span class="fs-4"> Fecha: {{ $fecha}}  </span>
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="bg-primary text-light fs-6 fw-bold text-center">

                <td class="alert alert-info" colspan="8">
                    <span>Fecha y hora del punche - Verde si entro / Rojo si salio</span>
                </td>

                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
