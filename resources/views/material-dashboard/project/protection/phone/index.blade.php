@extends('material-dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="my-5">{{$project->name}}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-auto">
            <a href="{{route('project.protection.phone.create', $project->id)}}" class="btn btn-primary">
                Добавить номер телефона
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped table-hover rounded text-center">
                <thead class="table-dark">
                    <th>#</th>
                    <th>Телефон</th>
                    <th>Блокировать</th>
                    <th>Число вхождений</th>
                    <th>Последнее вхождение</th>
                    <th>Дата создания</th>
                    <th>Дата изменения</th>
                    <th>Действия</th>
                </thead>
        
                <tbody>
                    @foreach ($phones as $phone)
                        <tr>
                            <td>{{$phone->id}}</td>
                            <td>{{$phone->phone}}</td>
                            <td class="fw-bold">
                                @if ($phone->enabled)
                                    <span class="text-success">Да</span>
                                @else
                                    <span class="text-secondary">Нет</span>
                                @endif
                            </td>
                            <td>{{$phone->entries}}</td>
                            <td>{{$phone->last_entry_date_tz?->format('d.m.Y H:i:s') ?? null}}</td>
                            <td>{{$phone->created_at_tz->format('d.m.Y H:i:s')}}</td>
                            <td>{{$phone->updated_at_tz->format('d.m.Y H:i:s')}}</td>
        
                            <td>
                                <a href="{{route('project.protection.phone.edit', [$project->id, $phone->id])}}" class="btn btn-primary me-2">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        
                <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$phones->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection