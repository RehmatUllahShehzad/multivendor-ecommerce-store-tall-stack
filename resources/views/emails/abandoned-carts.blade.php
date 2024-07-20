@component('mail::message')
# We noticed you left something in your cart

Hi {{ $user->name }},
<br>

## Would you like to complete your purchase ?


@component('mail::table')
| Item          |   Unit Price   | Quantity          | Total                   |
| :------------- |:--------------:|:-----------------:| -----------------------:|
@foreach($cart->extra_data as $item)
|  <div style="display: flex;align-items:center;justify-content:space-around;"><img style="width: 50px;height:50px;" src="{{ optional($item->model)->feature_image }}" alt=""> <div><strong>{{$item->name}}</strong></div></div> |   ${{number_format($item->price,2)}}    |   {{$item->quantity}} |   ${{number_format($item->getPriceSum(),2)}}    |
@endforeach
@endcomponent

@component('mail::button', ['url'=>url('/cart')])
Resume your Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
