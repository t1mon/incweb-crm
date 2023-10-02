@extends('layouts.app')

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100 bg-gradient-dark">
            <div class="container my-auto">
                <div class="row pt-7">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 rounded-0">
                            <div class="card-header p-0 position-relative mt-n4 z-index-2">
                                <div class="bg-gradient-secondary py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Регистрация</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'register', 'role' => 'form', 'method' => 'POST']) !!}
                                <div class="input-group my-2 flex-column">
                                    {!! Form::label('name', 'Имя', ['class' => 'm-0']) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('name') ? ' is-invalid' : ''), 'required', 'autofocus']) !!}

                                    @error('name')
{{--                                    <span class="invalid-feedback">{{ $message }}</span>--}}
                                    <span class="invalid-feedback">Неверный логин или пароль</span>
                                    @enderror
                                </div>

                                <div class="input-group my-2 flex-column">
                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                    {!! Form::email('email', old('email'), ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('email') ? ' is-invalid' : ''), 'required']) !!}

                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3 flex-column">
                                    {!! Form::label('password', 'Пароль', ['class' => 'control-label']) !!}
                                    {!! Form::password('password', ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}

                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group my-2 flex-column">
                                    {!! Form::label('password_confirmation', 'Повторите пароль', ['class' => 'm-0']) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control w-100 border rounded-0 p-2' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'required']) !!}

                                    @error('password_confirmation')
{{--                                    <span class="invalid-feedback">{{ $message }}</span>--}}
                                    <span class="invalid-feedback">Неверный логин или пароль</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    {!! Form::submit('Регистрация', ['class' => 'btn bg-gradient-info w-100 my-4 mb-2 rounded-0']) !!}
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
