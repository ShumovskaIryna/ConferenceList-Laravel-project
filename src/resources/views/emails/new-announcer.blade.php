@component('mail::message')
# New report! 

Dear {{$name}},

There is a new participant <b>{{$report_author}}</b> at the conference <b>{{$conf_title}}</b>.
The topic of new report <b>{{$report_topic}}</b>
The report time: {{$new_time_start}} - {{$new_time_finish}}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
