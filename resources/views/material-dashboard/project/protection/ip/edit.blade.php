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

                    <form action="{{route('project.protection.ip.update', [$project->id, $ip->id])}}" method="POST">
                        @method('PUT')
                        @include('material-dashboard.project.protection.ip.form')
                    </form>
                </div>

                <div class="card-footer border text-center">
                    <form action="{{route('project.protection.ip.destroy', [$project->id, $ip->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection