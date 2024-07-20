@component('mail::message')
# Tracking ID Added

Hi {{ $username }},

Your Order tracking Id is {{ $trackingId }} for Order Number {{ $orderPackage->order->order_number }}
<br>
<a href="{{route('customer.orders.show', $orderPackage->order->id)}}">Link to your order</a>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent