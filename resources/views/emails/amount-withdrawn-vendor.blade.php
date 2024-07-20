@component('mail::message')
@if ($toAdmin)
# Withdraw successful

Hi Admin, <br>
{{ $user->name }}, has made a successful withdrawl.
@else
Hi {{ $user->name }},

Withdraw successful <br>
@endif

Amount:
${{ $balance }}

If you are having any issues with your account, please don’t hesitate to contact us. <br>

Thanks! <br>
{{ config('app.name') }} <br>
@endcomponent
