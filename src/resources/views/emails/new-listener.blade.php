@component('mail::message')
# You have new listener!

Dear {{$name}},

A new listener {{$new_listener}} has joined the conference 
{{$conf_title}}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
