<div class="form-group">
    {!! Form::label('name', 'Название проекта') !!}
    {!! Form::text('name', null, ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder'=> 'Введите имя нового проекта', 'required']) !!}

    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

