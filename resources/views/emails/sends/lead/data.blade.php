@php
    $fields = $lead->project->settings['email']['fields'];
@endphp

ДАННЫЕ КЛИЕНТА:

ФИО -> {{ $lead->name }}
Номер телефона -> {{ phone_format($lead->phone) }}

Другие заполненные данные клиента:

@if(count($fields) > 0)
@foreach($fields as $field)
@if(!is_null($lead->$field))
{{$lead->$field}}
@endif
@endforeach
@endif

