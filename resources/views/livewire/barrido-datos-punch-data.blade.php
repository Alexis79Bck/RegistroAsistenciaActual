<div>
    <div class="container mt-3">

        <div class="row row-cols-2 justify-content-center">
            <div class="col text-center">
                @if ($nRegNuevos > 0)
                    <div class="alert alert-info " role="alert">
                        <span >
                            Se ha encontrado <b class="fs-5 fw-bolder text-danger">{{ $nRegNuevos }}</b>  nuevos registros.
                        </span>
                        <br>
                        <button class="btn btn-outline-primary " type="button" wire:click="regPunchData" id="botonStatus">
                                <span >Cargar Registros</span>
                        </button>
                        <input type="hidden" id="nRegNuevos" wire:model="nRegNuevos">
                    </div>
                @else
                    <div class="alert alert-info " role="alert">

                        <span class="fs-6">
                            No existe nuevos registros.
                        </span>
                        <span class="spinner-grow spinner-grow-sm ml-5 fs-6 text-success" ></span>

                    </div>


                @endif

            </div>


        </div>
        <div class="row row-cols-2 justify-content-center">
            <div class="col">
                @if ($cargaCompleta)
                    <div class="alert alert-success alert-dimissible fade show " role="alert">
                        <span >
                            Carga Completada
                        </span>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close" wire:click="cerrarCargaCompletaMensaje"></button>

                    </div>
                @endif
            </div>
        </div>
        <div class="row row-cols-2 justify-content-center">
            <div class="col text-center">
                @if ($nNoRegistrados > 0)

                    <div class="alert alert-danger alert-dismissible fade {{ $nNoRegistrados > 0 ? 'show' : '' }}" role="alert">
                        <span>
                            Se ha encontrado {{ $nNoRegistrados }} de Empleados no registrado(s) en MeruLink.
                            <ul>
                            @for ($i = 1; $i <= $nNoRegistrados; $i++)
                                    <li>Cédula: {{ $cedNoRegistrados[$i] }}</li>

                            @endfor

                            </ul>
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @section('CustomJS')
        <script >
            $(document).ready(function() {

                $("#cargaCompleta").hide();


            });
        </script>
    @endsection


</div>
