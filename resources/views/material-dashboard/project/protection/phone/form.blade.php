@csrf

<div class="form-group my-2">
    <label for="ip">Номер телефона</label>
    <input type="phone" name="phone" id="phone" class="form-control border p-2" value="{{isset($phone) ? $phone->phone : null}}">
</div>

<div class="form-check my-2">
    <input type="hidden" name="enabled" value=0>
    <input type="checkbox" name="enabled" id="enabled" class="form-check-input" {{isset($phone) ? ($phone->enabled ? 'checked' : '') : 'checked'}} value=1>
    <label for="enabled" class="form-check-label">Блокировать</label>
</div>

<div class="my-2">
    <button type="submit" class="btn btn-primary mx-2">
        Сохранить
    </button>

    <a href="{{route('project.protection.ip.index', [$project->id])}}" class="btn btn-secondary mx-2">
        Отмена
    </a>
</div>