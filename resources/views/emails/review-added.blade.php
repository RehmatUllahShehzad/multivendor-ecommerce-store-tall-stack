@component('mail::message')
# Review Added

Hi {{ $username }},

{{ $reviewComment }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent