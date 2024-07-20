@component('mail::message')
# Hello {{ $order->user ? $order->user->name : $order->shipping_name }}
Status against order {{ $order->order_id }} is updated to {{ $order->status }}.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
