<div class="row my-2">
    <div class="col">
        {!! Form::label('service', 'Service:', ['class' => 'col-5 col-form-label']) !!}
    </div>
    <div class="col">
        <div class="input-group input-group-outline">
            {!! Form::text('service', $matomba?->service ?? null, ['class' => 'form-control', 'id' => 'service', 'placeholder' => 'Service (Id квиза)']) !!}
        </div>
    </div>
</div>