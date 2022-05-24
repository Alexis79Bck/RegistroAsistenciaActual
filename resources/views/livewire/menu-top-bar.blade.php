<div>

    <ul class="nav" id="topbar">

        <li class="nav-item {{ Route::currentRouteName() == 'inicio' ? 'active' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('inicio') }}">Inicio</a>
        </li>
        <li
            class="nav-item dropdowm {{ Route::currentRouteName() == 'registrar' || Route::currentRouteName() == 'registro_manual' ? 'active' : '' }}">
            <a class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Registrar</a>
            <ul class="dropdown-menu border border-dark shadow">
                <li><a class="dropdown-item" href="{{ route('registrar') }} ">Automático</a></li>
                <li><a class="dropdown-item" href="{{ route('registro_manual') }}">Manual</a></li>

            </ul>
            {{-- <a class="nav-link link-light" aria-current="page" href="{{ route('registrar') }}">Registrar</a> --}}
        </li>
        <li class="nav-item {{ Route::currentRouteName() == 'consultar_asistencia' ? 'active' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('consultar_asistencia') }}">Consultar</a>
        </li>
        <li
            class="nav-item dropdowm {{ Route::currentRouteName() == 'registrar' || Route::currentRouteName() == 'registro_manual' ? 'active' : '' }}">
            <a class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Prenomina</a>
            <ul class="dropdown-menu border border-dark shadow">
                <li><a class="dropdown-item" href="{{ route('registrar') }} ">Incidecias</a></li>
                <li><a class="dropdown-item" href="{{ route('registro_manual') }}">Resumen</a></li>

            </ul>
            {{-- <a class="nav-link link-light" aria-current="page" href="{{ route('registrar') }}">Registrar</a> --}}
        </li>
        <li class="nav-item {{ Route::currentRouteName() == 'auditoria_asistencia' ? 'active' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('auditoria_asistencia') }}">Auditoría</a>
        </li>

    </ul>
</div>
