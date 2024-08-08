<div class="card">
    <div class="card-body">
        <h5 class="card-title">Интеграция в сервис gudok.tel</h5>

        <ol>
            <li>Убедитесь, что проект в CRM включен</li>
            <li>Войдите в настройки управления проекта "Гудок"</li>
            <li>В разделе "Уведомления" включите опцию "Вебхуки"</li>
            <li>Скопируйте в поле "Адрес (URL)" следующий URL: <b>https://crm.incweb.ru/api/v2/integrations/gudok/{{$project->id}}/register-host</b> и нажмите кнопку "Тестовый вебхук". В поле "Метод передачи" должен быть указан метод POST</li>
            <li>Дождитесь успешного ответа с кодом 201</li>
            <li>Скопируйте в поле "Адрес (URL)" следующий URL: <b>https://crm.incweb.ru/api/v2/integrations/gudok/{{$project->id}}/add-lead</b> и нажмите кнопку "Сохранить" внизу страницы</li>
        </ol>
    </div>

</div>
