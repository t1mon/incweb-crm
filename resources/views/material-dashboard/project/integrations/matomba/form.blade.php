<div class="row my-2">
    <div class="col">
        {!! Form::label('host', 'Service:', ['class' => 'col-5 col-form-label']) !!}
    </div>
    <div class="col">
        <div class="input-group input-group-outline">
            {!! Form::text('host', $matomba?->host ?? null, ['class' => 'form-control', 'id' => 'host', 'placeholder' => 'Название проекта']) !!}
        </div>
    </div>
</div>
