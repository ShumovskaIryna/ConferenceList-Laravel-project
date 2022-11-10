@component('mail::message')
# New comment! 

Dear {{$name}},

At the conference {{$conf_title}} the user <b>{{$comment_author}}</b>
has just left a comment on your report <a href=""><b>{{$report_topic}}</b></a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent