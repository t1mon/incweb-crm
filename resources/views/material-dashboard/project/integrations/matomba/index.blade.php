@extends('material-dashboard.layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <h1 class="h1 text-uppercase">Интеграции Matomba</h1>
    </div>

    @if ($matombas->isNotEmpty())
        @foreach ($matombas as $matomba)
            <div class="row justify-content-center">
                {{-- Id квиза --}}
                <div class="col-auto">
                    <b>Service (id квиза): </b> {{$matomba->service}}
                </div>

                {{-- Кнопка "Редактировать" --}}
                <div class="col-auto">
                    <a href="{{route('project.integrations.matomba.edit', $matomba->id)}}" class="btn btn-info">
                        <i class="fa fa-pencil fs-6" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Кнопка "Удалить" --}}
                <div class="col-auto">
                    <form action="{{route('project.integrations.matomba.destroy', $matomba->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        
                        <button type="submit" class="btn btn btn-primary">
                            <i class="fa fa-trash fs-6" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="row justify-content-center">
            <div class="col-auto">
                Интеграции отсутствуют
            </div>

            {{-- Кнопка "Добавить" --}}
            <div class="col-auto">
                <a href="{{route('project.integrations.matomba.create', $project->id)}}" class="btn btn-primary">
                    Добавить
                </a> 
            </div>
        </div>
    @endif
</div>
@endsection