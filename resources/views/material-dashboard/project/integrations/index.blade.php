@extends('material-dashboard.layouts.app')

@section('content')

<div>
    <ul class="nav nav-tabs">
        {{--VK--}}
        <li class="nav-item">
            <a  class="nav-link active" data-bs-toggle="tab" href="#vk">
                ВКонтакте
            </a>
        </li>

        {{--REST API--}}
        <li class="nav-item">
            <a  class="nav-link" data-bs-toggle="tab" href="#restapi">
                REST API
            </a>
        </li>

        {{-- Mango Office --}}
        <li class="nav-item">
            <a  class="nav-link" data-bs-toggle="tab" href="#mango">
                Mango Office
            </a>
        </li>

        {{-- Matomba --}}
        <li class="nav-item">
            <a  class="nav-link" data-bs-toggle="tab" href="#matomba">
                Matomba
            </a>
        </li>

        {{-- Гудок --}}
        <li class="nav-item">
            <a  class="nav-link" data-bs-toggle="tab" href="#gudok">
                Гудок
            </a>
        </li>
    </ul>
</div>

{{--Содержимое вкладок--}}
<div class="tab-content">
    {{--VK--}}
    <div class="tab-pane fade show active" id="vk" role="tabpanel">
        @include('material-dashboard.project.integrations.vk.index')
    </div>

    {{--REST API--}}
    <div class="tab-pane fade show" id="restapi" role="tabpanel">
        @include('material-dashboard.project.integrations.restapi')
    </div>

    {{--Mango Office--}}
    <div class="tab-pane fade show" id="mango" role="tabpanel">
        <a href="{{route('project.integrations.mango.index', $project->id)}}" class="link-primary">Интеграции с Mango Office</a>
    </div>

    {{--Matomba--}}
    <div class="tab-pane fade show" id="matomba" role="tabpanel">
        <a href="{{route('project.integrations.matomba.index', $project->id)}}" class="link-primary">Интеграции с Matomba</a>
    </div>

    {{--Гудок--}}
    <div class="tab-pane fade show" id="gudok" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Интеграция в сервис gudok.tel</h5>
        
                <p class="card-text">
                    <a href="{{route('project.integrations.gudok.create-token', $project->id)}}" class="btn-primary btn-lg">Добавить интеграцию</a>
                </p>

                <p>
                    Подключенные интеграции находятся в разделе "Список хостов" в <a href="{{route('project.settings-basic', $project->id)}}">настройках проекта</a>.
                </p>

                <p>
                    Хосты, связанные с сервисом Гудок, генерируются по следующему шаблону:
                    <span class='text-primary'>crm<span class="text-dark fw-bold">{id проекта в CRM}</span>-gudok<span class="text-dark fw-bold">{id проекта в Гудок}</span></span>
                </p>

                <p>
                    Пример: <span class="text-primary">crm284-gudok19.ru</span>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection