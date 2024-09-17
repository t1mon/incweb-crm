@extends('material-dashboard.layouts.app')

@section('content')
    <div class="row justify-content-center my-2">
        <div class="col-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Проект: {{$project->name}}</h5>
            
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('project.protection.ip.store', [$project->id])}}" method="POST">
                        @include('material-dashboard.project.protection.ip.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection