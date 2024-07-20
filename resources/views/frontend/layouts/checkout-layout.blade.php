<x-frontend.layouts.master-layout :title="$title" :description="$description">
    <div class="inner-section">
        <div class="main-padding">
            <section>
                <div class="container">
                    <div class="status-bar">
                        <div class="statusbar-steps-wrap d-flex justify-content-between">
                            <div class="step text-center done">
                                <div class="step-icon d-flex justify-content-center">
                                    @if ($currentStep == 'shipping')
                                        <img class="check" src="{{ asset('frontend/images/cart-icon.svg') }}" alt="">
                                    @else
                                        <img class="cart" src="{{ asset('frontend/images/cart-icon.svg') }}" alt="">
                                        <img class="check" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                    @endif
                                </div>
                                <div class="step-title">
                                    <p class="text-uppercase">Shipping Address</p>
                                </div>
                            </div>
                            <div class="step text-center {{ $currentStep == 'billing' || $currentStep == 'payment' || $currentStep == 'place-order' ? 'current' : '' }}">
                                <div class="step-icon d-flex justify-content-center ">
                                    @if ($currentStep == 'payment' || $currentStep == 'place-order')
                                        <img class="cart" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                    @else
                                        <img class="cart" src="{{ asset('frontend/images/cart-icon.svg') }}" alt="">
                                        <img class="check" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                    @endif
                                </div>
                                <div class="step-title">
                                    <p class="text-uppercase">Billing Address</p>
                                </div>
                            </div>
                            <div class="step text-center {{ $currentStep == 'payment' || $currentStep == 'place-order' ? 'current' : '' }}">
                                <div class="step-icon d-flex justify-content-center">
                                    @if ($currentStep == 'place-order')
                                        <img class="cart" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                    @else
                                        <img class="cart" src="{{ asset('frontend/images/cart-icon.svg') }}" alt="">
                                        <img class="check" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                    @endif
                                </div>
                                <div class="step-title">
                                    <p class="text-uppercase">Payment</p>
                                </div>
                            </div>
                            <div class="step text-center {{ $currentStep == 'place-order' ? 'current' : '' }}">
                                <div class="step-icon d-flex justify-content-center">
                                    <img class="cart" src="{{ asset('frontend/images/cart-icon.svg') }}" alt="">
                                    <img class="check" src="{{ asset('frontend/images/check-icon.svg') }}" alt="">
                                </div>
                                <div class="step-title">
                                    <p class="text-uppercase">Place Order</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            {{ $slot ?? '' }}

        </div>
    </div>
</x-frontend.layouts.master-layout>
