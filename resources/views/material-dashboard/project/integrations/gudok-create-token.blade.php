@extends('material-dashboard.layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Добавление интеграции в gudok.tel</h5>

        <p>
            <ol>
                <li>Убедитесь, что данный проект в CRM <a href="{{route('project.settings-basic', $project->id)}}" class="link-primary" target="_blank">включен</a></li>
                <li>Войдите в настройки управления проекта "Гудок". В разделе "Уведомления" включите опцию "Вебхуки"</li>
                <li>Скопируйте в поле "Адрес (URL)" следующий URL:
                    <input type="text" readonly value="{{route('v2.integrations.gudok.register-host', ['project' => $project->id, 'token' => $token->token])}}" class="form-control">
                    <span class="text-sm">
                        <strong class="text-danger">Ссылка действительна до {{$token->created_at->timezone('Europe/Samara')->addMinutes(\App\Models\Project\Integrations\GudokToken::VALIDITY_PERIOD)->format('H:i:s d.m.Y')}} по Самаре!!!</strong>
                        Если время вышло, обновите страницу.
                    </span>
                    <br>
                </li>
                <li>В поле "Метод передачи" должен быть указан метод POST. Нажмите кнопку "Тестовый вебхук". Дождитесь успешного ответа с кодом 201</li>
                <li>Скопируйте в поле "Адрес (URL)" следующий URL:
                    <input type="text" readonly value="{{route('v2.integrations.gudok.add-lead', $project->id)}}" class="form-control">
                </li>
                <li>Нажмите кнопку "Сохранить" внизу страницы</li>
            </ol>
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

@endsection