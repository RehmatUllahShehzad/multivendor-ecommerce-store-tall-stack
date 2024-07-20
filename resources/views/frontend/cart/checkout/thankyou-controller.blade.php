
<x-slot name="title">
    Thankyou
</x-slot>
<div class="inner-section">
    <div class="thank-you-bg w-100" style="background-image: url({{asset('frontend/images/thank-you.png')}});">
        <div class="container">
            <div class="main-box w-100 d-flex justify-content-center align-items-center">
                <div class="thank-you-spacing">
                    <div class="box text-center w-100 p-sm-4 p-3 text-white bg-opacity-10">
                        <h1 class="pt-2">Thank You</h1>
                        <h4 class="p-2">We received your order #<span>{{ $order->order_number }}</span> and it is in process.</h4>
                        {{-- <p class="pt-2 pb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vestibulum
                            facilisis posuere. Suspendisse convallis rutrum nisl eget aliquam. Quisque ultrices ipsum in
                            elementum cursus.</p> --}}
                        <a href="/" class="theme-button">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
