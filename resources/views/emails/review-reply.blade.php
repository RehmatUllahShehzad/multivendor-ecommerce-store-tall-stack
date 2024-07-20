@component('mail::message')
# Response To Your Review "{{ $reviewSubject }}"

Hi {{ $review->user->name }},

{{ $reviewComment }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
