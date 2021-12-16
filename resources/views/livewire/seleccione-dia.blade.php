<div class="col w-25 ">
    <div class=" form-group ">         
        <div class="input-group input-group-sm"  > 
            {!! Form::label('fecha', ' Fecha:', ['class'=>'form-label bg-primary text-white input-group-text fw-bold']) !!}
            {!! Form::date('fecha', null, ['class'=>'form-control form-control-sm',  'autocomplete'=>'off', 'wire:model.lazy'=>'fecha','wire:change'=>'lafecha','id'=>'lafecha','min'=> date('Y-m-d', strtotime('-13 days')),'max'=> date('Y-m-d', strtotime('today'))]) !!}
            
        </div>
    </div> 
</div>
