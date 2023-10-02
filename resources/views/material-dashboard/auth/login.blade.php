@extends('material-dashboard.layouts.auth')

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100 bg-gradient-dark">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 rounded-0">
                            <div class="card-header p-0 position-relative mt-n4 z-index-2">
                                <div class="bg-gradient-secondary py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Войти</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'login', 'role' => 'form', 'method' => 'POST', 'class' => 'text-start']) !!}
                                    <div class="input-group my-2 flex-column">
                                        {!! Form::label('email', __('validation.attributes.email'), ['class' => 'm-0']) !!}
                                        {!! Form::email('email', old('email'), ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('email') ? ' is-invalid' : ''), 'required', 'autofocus']) !!}

                                        @error('email')
{{--                                            <span class="invalid-feedback">{{ $message }}</span>--}}
                                            <span class="invalid-feedback">Неверный логин или пароль</span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 flex-column">
                                        {!! Form::label('password', 'Пароль', ['class' => 'm-0']) !!}
                                        {!! Form::password('password', ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}

                                        @error('password')
{{--                                            <span class="invalid-feedback">{{ $message }}</span>--}}
                                        <span class="invalid-feedback">Неверный логин или пароль</span>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input id="remember" type="checkbox" name="remember" class="form-check-input" value="{{old('remember')}}">
                                        <label class="form-check-label mb-0 ms-2" for="remember">Запомнить меня</label>
                                    </div>
                                    <div class="text-center">
                                        {!! Form::submit('Войти', ['class' => 'btn bg-gradient-info w-100 my-4 mb-2 rounded-0']) !!}
                                        {{ link_to('/password/reset', 'Забыли пароль?', ['class' => 'btn btn-link text-info'])}}
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Нет учётной записи?
                                        {{ link_to('register', __('auth.sign_up'), ['class' => 'text-info font-weight-bold'])}}
                                    </p>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>





{{--<div class="row justify-content-md-center">--}}
{{--    <div class="col-md-6">--}}
{{--        <h1>@lang('auth.login')</h1>--}}

{{--        {!! Form::open(['route' => 'login', 'role' => 'form', 'method' => 'POST']) !!}--}}
{{--            <div class="form-group">--}}
{{--                {!! Form::label('email', __('validation.attributes.email'), ['class' => 'control-label']) !!}--}}
{{--                {!! Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required', 'autofocus']) !!}--}}

{{--                @error('email')--}}
{{--                    <span class="invalid-feedback">{{ $message }}</span>--}}
{{--                @enderror--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                {!! Form::label('password', __('validation.attributes.password'), ['class' => 'control-label']) !!}--}}
{{--                {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}--}}

{{--                @error('password')--}}
{{--                    <span class="invalid-feedback">{{ $message }}</span>--}}
{{--                @enderror--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <div class="checkbox">--}}
{{--                    <label>--}}
{{--                        {!! Form::checkbox('remember', null, old('remember')) !!} @lang('auth.remember_me')--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                {!! Form::submit(__('auth.login'), ['class' => 'btn btn-primary']) !!}--}}
{{--                {{ link_to('/password/reset', __('auth.forgotten_password'), ['class' => 'btn btn-link'])}}--}}
{{--            </div>--}}
{{--        {!! Form::close() !!}--}}

{{--        <hr>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
