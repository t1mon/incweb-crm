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
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Создание проекта</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['project.store'], 'method' =>'POST']) !!}

                                @include('project/_form')

                                <div class="d-flex gap-2">
                                    {{ link_to_route('project.index', __('forms.actions.back'), [], ['class' => 'btn bg-gradient-info w-100 my-4 mb-2 rounded-0']) }}
                                    {!! Form::submit(__('forms.actions.save'), ['class' => 'btn bg-gradient-success w-100 my-4 mb-2 rounded-0']) !!}
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
