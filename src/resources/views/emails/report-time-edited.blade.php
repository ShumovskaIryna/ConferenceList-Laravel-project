@component('mail::message')
# Update time of the report! 

Dear {{$name}},

At the conference <b>{{$conf_title}}</b> participant <b>{{$report_author}}</b> 
rescheduled the report <b>{{$report_topic}}</b>.
New report time: {{$new_time_start}} - {{$new_time_finish}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent