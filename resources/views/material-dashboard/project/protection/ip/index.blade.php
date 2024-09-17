@extends('material-dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="my-5">{{$project->name}}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-auto">
            <a href="{{route('project.protection.ip.create', $project->id)}}" class="btn btn-primary">
                Добавить IP-адрес
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped table-hover rounded">
                <thead class="table-dark">
                    <th>#</th>
                    <th>IP</th>
                    <th>Отслеживание</th>
                    <th>Отслеживать до</th>
                    <th>Добавлен</th>
                    <th>Последнее изменение</th>
                    <th>Действия</th>
                </thead>
        
                <tbody>
                    @foreach ($ips as $ip)
                        <tr>
                            <td>{{$ip->id}}</td>
                            <td>{{$ip->ip}}</td>
                            <td class="fw-bold">
                                @if ($ip->enabled)
                                    <span class="text-success">Да</span>
                                @else
                                    <span class="text-secondary">Нет</span>
                                @endif
                            </td>
                            <td>{{$ip->block_until}}</td>
                            <td>{{$ip->created_at}}</td>
                            <td>{{$ip->created_at}}</td>
        
                            <td>
                                <a href="{{route('project.protection.ip.edit', [$project->id, $ip->id])}}" class="btn btn-primary me-2">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        
                <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$ips->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection