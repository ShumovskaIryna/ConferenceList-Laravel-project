@component('mail::message')
# Update time of the report! 

Dear {{$name}},

At the conference {{$conf_title}} participant <b>{{$report_author}}</b> 
with a report on the topic <b>{{$report_topic}}</b>
rescheduled the report
New report time: {{$new_time_start}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent