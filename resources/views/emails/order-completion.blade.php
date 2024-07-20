@component('mail::message')

# Welcome to {{ setting('site_title') }}

Congratulations! {{ $orderPackage->customer->username }}, Your order {{ $orderPackage->order->order_number }} is completed
<br>
You can share your feedback through this link <a href="{{route('customer.orders.show', $orderPackage->order->id)}}">Add Review</a>
<br>
Thanks so much,
<br>
Cait, Ali, Drew, Anthony, Kenny,
The time of local is now.

<br>
{{ setting('site_title') }} <br>
@endcomponent
