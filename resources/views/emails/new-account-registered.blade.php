@component('mail::message')

# Welcome to {{ config('app.name') }}

Hi there and thank you so much for shopping People’s Pantry. 
<br>
Your purchase will arrive in {{ setting('order_payment_processing_time') }}. If you have any issues at all please contact us at {{ setting('phone') }}. 
<br>
We promise a person will answer :)
Thanks so much,
Cait, Ali, Drew, Anthony, Kenny,

Thanks! <br>
{{ config('app.name') }} <br>
{{ setting('contact_us_email') }} <br>
@endcomponent
