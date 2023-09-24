@extends('material-dashboard.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                {!! Form::open(['url' => route('project.integrations.matomba.update', $matomba->id), 'method' => 'PUT']) !!}

                <h5 class="card-header text-center text-uppercase">{{$matomba->name}}</h5>
                
                <div class="card-body">
                    <div class="container-fluid">
                        {!! Form::hidden('project_id', $matomba->project_id) !!}
                        @include('material-dashboard.project.integrations.matomba.form', ['matomba' => $matomba])
                    </div>
                </div>

                <div class="card-footer">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-auto text-center">
                                {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                            </div>
                            <div class="col-auto text-center">
                                <a href="{{route('project.integrations.matomba.index', $project->id)}}" class="btn btn-info">
                                    Назад
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection