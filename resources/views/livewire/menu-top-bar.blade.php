<div>

    <ul class="nav" id="topbar">

        <li class="nav-item {{ Route::currentRouteName() == 'inicio' ? 'active' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('inicio') }}">Inicio</a>
        </li>
        @if (session()->get('rol_usuario') == 'Super-Admin' || session()->get('rol_usuario') == 'Recursos Humanos')
        <li
            class="nav-item dropdowm {{ Route::currentRouteName() == 'registrar' || Route::currentRouteName() == 'registro_manual' ? 'active text-link' : '' }}">
            <a class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Registrar</a>
            <ul class="dropdown-menu border border-dark shadow">
                <li><a class="dropdown-item" href="{{ route('registrar') }} ">Automático</a></li>
                <li><a class="dropdown-item" href="{{ route('registro_manual') }}">Manual</a></li>

            </ul>
            {{-- <a class="nav-link link-light" aria-current="page" href="{{ route('registrar') }}">Registrar</a> --}}
        </li>
        @endif
        <li class="nav-item {{ Route::currentRouteName() == 'consultar_asistencia' ? 'active text-link' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('consultar_asistencia') }}">Consultar</a>
        </li>
        <li
            class="nav-item dropdowm {{ Route::currentRouteName() == 'incidencias' || Route::currentRouteName() == 'resumen' ? 'active text-link' : '' }}">
            <a class="nav-link  dropdown-toggle " data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Prenomina</a>
            <ul class="dropdown-menu border border-dark shadow">
                <li><a class="dropdown-item text-dark" href="{{ route('incidencias') }} ">Incidencias</a></li>
                {{-- <li><a class="dropdown-item text-dark" href="{{ route('resumen') }}">Resumen</a></li> --}}

            </ul>
            {{-- <a class="nav-link link-light" aria-current="page" href="{{ route('registrar') }}">Registrar</a> --}}
        </li>
        @if (session()->get('rol_usuario') == 'Super-Admin' || session()->get('rol_usuario') == 'Recursos Humanos')
        <li class="nav-item {{ Route::currentRouteName() == 'auditoria_asistencia' ? 'active text-link' : '' }}">
            <a class="nav-link " aria-current="page" href="{{ route('auditoria_asistencia') }}">Auditoría</a>
        </li>
        @endif

    </ul>
</div>
