@component('mail::message')

# Welcome to {{ config('app.name') }}
@if ($toAdmin)
A vendor request has been submitted to the Admin for Approval. <br>

Please view the admin panel for reviewing the pending vendor requests <br>
@else

Thank you for registration. Your request has been submitted to the Admin for Approval. <br>

If you are having any issues with your account, please don’t hesitate to contact us. <br>
@endif
Thanks! <br>
{{ config('app.name') }} <br>
@endcomponent
