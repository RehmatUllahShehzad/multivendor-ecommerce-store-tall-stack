@component('mail::message')

Hi {{ $user->name }},

Thank you for registration. Your request has been rejected <br>

Reason:
{{ $rejectedReason }}

If you are having any issues with your account, please don’t hesitate to contact us. <br>

Thanks! <br>
{{ config('app.name') }} <br>
@endcomponent
