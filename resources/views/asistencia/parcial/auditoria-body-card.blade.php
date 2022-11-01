@if ($optionNumber === 1 || $optionNumber === 2)
    <ol class="list-group list-group-numbered ">
        <li class="list-group-item  ">
            <div class="  font-monospace  "> {{$resultado[$i][$j]['Registros'][$k]->PunchTime}}  -  Mediante {{ $resultado[$i][$j]['Registros'][$k]->PunchType == 'FP' ? 'Huella Dactilar' : 'Reconocimiento Facial' }}. </div>
        </li>
    </ol>
@endif

@if ($optionNumber === 3 || $optionNumber === 5)
    <ol class="list-group list-group-numbered ">
        <li class="list-group-item  ">
            <div class="  font-monospace "> {{$resultado[$j]['Registros'][$k]->PunchTime}}  -  Mediante {{ $resultado[$j]['Registros'][$k]->PunchType == 'FP' ? 'Huella Dactilar' : 'Reconocimiento Facial' }}. </div>
        </li>
    </ol>
@endif

@if ($optionNumber === 4 || $optionNumber === 6 || $optionNumber === 7 || $optionNumber === 8)
    <ol class="list-group list-group-numbered ">
        <li class="list-group-item  ">
            <div class=" font-monospace "> {{$resultado['Registros'][$k]->PunchTime}}  -  Mediante {{ $resultado['Registros'][$k]->PunchType == 'FP' ? 'Huella Dactilar' : 'Reconocimiento Facial' }}. </div>
        </li>
    </ol>
@endif


