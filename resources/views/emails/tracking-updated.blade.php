@component('mail::message')
# Hello {{ $order->user ? $order->user->name : $order->shipping_name }}
Your tracking number against order {{ $order->order_id }} is {{ $order->tracking_number }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
