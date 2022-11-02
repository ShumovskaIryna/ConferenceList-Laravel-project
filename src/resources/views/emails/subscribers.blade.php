@component('mail::message')
# Welcome to the first Newsletter

Dear {{$email}},

MEYOW

@component('mail::button', ['url' => 'enter your desired url'])
Blog
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent