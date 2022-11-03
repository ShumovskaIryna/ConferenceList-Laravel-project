@component('mail::message')
# Sorry ...

Dear {{$participant}},

Conference {{$title}} 
was deleted by Admin.

Thanks,<br>
{{ config('app.name') }}
@endcomponent