@component('mail::message')
# {{ __('Reset Password Notification') }}
  
@lang('You are receiving this email because we received a password reset request for your account.')
   
@component('mail::button', ['url' => $link])
@lang('Reset Password')
@endcomponent

@lang('If you did not request a password reset, no further action is required.')

Thanks,<br>
{{ config('app.name') }}
@endcomponent