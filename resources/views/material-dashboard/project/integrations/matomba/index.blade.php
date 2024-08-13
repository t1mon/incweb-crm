@extends('material-dashboard.layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <h1 class="h1 text-uppercase">Интеграции Matomba</h1>
    </div>
</div>

{{-- Ссылка на вебхук для Matomba в нашей CRM --}}
<div class="row justify-content-center my-3">
    <div class="col-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">
                    Вставьте эту ссылку в настройки квиза в Matomba:
                </h1>
                <p class="card-text text-center">
                    {{$webhookUrl}}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Кнопка "Добавить" --}}
<div class="row justify-content-center">
    <div class="col-auto">
        <a href="{{route('project.integrations.matomba.create', $project->id)}}" class="btn btn-primary">
            Добавить
        </a>
    </div>
</div>

@if ($matombas->isNotEmpty())
    <div class="row justify-content-center">
        <div class="col-auto">
            <table class="table table-hover table-bordered table align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>URL</th>
                        <th colspan="2">Действия</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($matombas as $matomba)
                        <tr>
                            <td>{{$matomba->host}}</td>

{{--                            <td>--}}
{{--                                <a href="{{route('project.integrations.matomba.edit', $matomba->id)}}" class="btn btn-info">--}}
{{--                                    <i class="fa fa-pencil fs-6" aria-hidden="true"></i>--}}
{{--                                </a>--}}
{{--                            </td>--}}

                            <td>
                                <form action="{{route('project.integrations.matomba.destroy', $matomba->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn btn-primary">
                                        <i class="fa fa-trash fs-6" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="row justify-content-center">
        <div class="col-auto">
            Интеграции отсутствуют
        </div>
    </div>
@endif

@endsection
