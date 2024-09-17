@csrf
<div class="form-group">
    <input type="hidden" name="project_id" value="{{$project->id}}">
    <input type="hidden" name="enabled" value=0>
</div>

<div class="form-group my-2">
    <label for="ip">IP-адрес</label>
    <input type="text" name="ip" id="ip" class="form-control border p-2" value="{{isset($ip) ? $ip->ip : null}}">
</div>

<div class="form-check my-2">
    <input type="checkbox" name="enabled" id="enabled" class="form-check-input" {{isset($ip) ? ($ip->enabled ? 'checked' : '') : 'checked'}} value=1>
    <label for="enabled" class="form-check-label">Отслеживать</label>
</div>

<div class="form-group my-2">
    <label for="enabled">Блокировать до</label>
    <input type="datetime" name="block_until" id="block_until" class="form-control border p-2" value="{{isset($ip) ? $ip->block_until : now()->addDays(1)}}"></div>

<div class="my-2">
    <button type="submit" class="btn btn-primary mx-2">
        Сохранить
    </button>

    <a href="{{route('project.protection.ip.index', [$project->id])}}" class="btn btn-secondary mx-2">
        Отмена
    </a>
</div>