@if ($optionNumber === 1 || $optionNumber === 2)
<div class="card-title">
    <h5 class=" text-center fs-4">
        <span  class=" text-primary">{{$resultado[$i][$j]['Departamento']}} |  {{$resultado[$i][$j]['Empleado']}}  </span>
    </h5>
</div>
@endif

@if ($optionNumber === 3 || $optionNumber === 5 )
<div class="card-title">
    <h5 class=" text-center fs-4">
        <span  class=" text-primary">{{$resultado[$j]['Departamento']}} |  {{$resultado[$j]['Empleado']}}  </span>
    </h5>
</div>
@endif

@if ($optionNumber === 4 || $optionNumber === 6 || $optionNumber === 7 || $optionNumber === 8)
<div class="card-title">
    <h5 class=" text-center fs-4">
        <span class=" text-primary">{{$resultado['Departamento']}} |  {{$resultado['Empleado']}}  </span>
    </h5>
</div>
@endif



