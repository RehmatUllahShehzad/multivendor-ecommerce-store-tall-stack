@component('mail::message')


@component('mail::panel')


<h1 style="text-align:center;"> Order Summary</h1>
<p style="text-align:center;margin:0;">Order#: {{ $order->order_number }}</p>
<p style="text-align:center;margin:0;">Date: {{ $order->created_at->format('M d, Y') }}</p>

@endcomponent

# Order Details <br>
<strong>Payment Method: </strong>Credit Card <br>
<hr>
<div style="width:100%;display: flex; align-items:start; justify-content:space-around;">
<div style="width: 50%;padding:0 10px;">
<br>
</div>

</div>

@component('mail::table')
|Vendor Name | Item | Unit Price | Quantity | Total |
| :------------- | :------------- |:--------------:|:-----------------:| -----------------------:|
{{ $orderPackage->vendor->vendor_name }}|
@foreach ($orderPackage->items as $packageItem)
|   |<div style="display: block; align-items:center;justify-content:space-around;"><img style="width: 50px;height:50px;" src="{{ $packageItem->product->getThumbnailUrl() }}" alt=""><div style="margin: 15px 0 0 10px; width: 150px;"><strong>{{ $packageItem->product->title }}</strong></div></div> | ${{ number_format($packageItem->price, 2) }} | {{ $packageItem->quantity }} | ${{ $packageItem->total() }}|
@endforeach
|   |     |  <strong>Sub Total</strong>   |   ${{number_format($orderPackage->sub_total, 2)}}    |
@if ($order->shipping_fee)
|   |     |  <strong>Shipping</strong>   |   ${{number_format($orderPackage->shipping_fee, 2)}}    |
@endif
|   |     |  <strong>Service Fee</strong>   |   -${{number_format($orderPackage->service_fee, 2)}}    |
|   |     |  <strong>Total</strong>   |   ${{number_format($orderPackage->vendorTotal(), 2) }}   |
@endcomponent
@endcomponent

    