@component('mail::message')
# {{trans('global.email.contact-us')}}

@foreach($data as $key=>$value)
<strong>{{Str::of($key)->replace("_"," ")->title()}}:</strong> {{$value}} <br>
@endforeach

Thanks,<br>
{{ setting('site_title') }}
@endcomponent
