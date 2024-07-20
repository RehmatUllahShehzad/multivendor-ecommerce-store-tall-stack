<x-slot name="pageTitle">
    Attach Debit Card
</x-slot>
<x-slot name="pageDescription">
    Attach Debit Card
</x-slot>
<div class="vender-product-management-right">
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>Add Debit Card</h3>
        </div>
    </div>
    <form wire:submit.prevent="submit">
        <div class="managed-products-wrap">
            <div class="vender-products-edit">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="get-form">
                            <label for="Name on card">Name on Card</label>
                            <input wire:model.defer="name" type="text" class="form-control" id="nameOnCard"
                                placeholder="Name on Card">
                        </div>
                        @error('name')
                            <div class="get-form-error">
                                <div class="get-form-error">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="get-form">
                            <label for="card number">Card Number</label>
                            <input type="text" wire:model.defer="card_number"
                                class="form-control number-font mask_us_credit_card" id="cardNumber" placeholder="Card Number">
                        </div>
                        @error('card_number')
                            <div class="get-form-error">
                                <div class="get-form-error">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-sm-6 col-6">
                        <div class="get-form">
                            <label for="month">MM</label>
                            <select class="form-control" wire:model.defer="exp_month">
                                <option value="" disabled>Choose Month</option>
                                @foreach (get_12_months() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('exp_month')
                            <div class="get-form-error">
                                <div class="get-form-error">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-sm-6 col-6">
                        <div class="get-form">
                            <label for="year">YY</label>
                            <select class="form-control number-font" id="floatingyy" wire:model.defer="exp_year">
                                <option value="" disabled>Choose Year</option>
                                @foreach (get_next_years(10, true) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('exp_year')
                            <div class="get-form-error">
                                <div class="get-form-error">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="get-form">
                            <label for="cvc">CVC</label>
                            <input wire:model.defer="cvc" type="text" class="form-control number-font" id="cvc"
                                placeholder="CVC">
                        </div>
                        @error('cvc')
                            <div class="get-form-error">
                                <div class="get-form-error">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-3 col-6 ps-0 pe-0">
                        <div class="whats-this">
                            <svg class="bank-icon" width="17" height="17" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9501 2.05015C9.2164 -0.68323 4.78413 -0.683535 2.05015 2.05015C-0.683535 4.78383 -0.68323 9.21609 2.05015 11.9501C4.78383 14.6832 9.21609 14.6835 11.9501 11.9501C14.6835 9.21609 14.6832 4.78413 11.9501 2.05015ZM7.91286 10.0436C7.91286 10.5479 7.50412 10.9567 6.99981 10.9567C6.4955 10.9567 6.08676 10.5479 6.08676 10.0436V6.39141C6.08676 5.8871 6.4955 5.47836 6.99981 5.47836C7.50412 5.47836 7.91286 5.8871 7.91286 6.39141V10.0436ZM6.98368 4.8307C6.45776 4.8307 6.10715 4.45817 6.1181 3.9983C6.10715 3.51621 6.45776 3.15494 6.99433 3.15494C7.53121 3.15494 7.87086 3.51651 7.88212 3.9983C7.88182 4.45817 7.53151 4.8307 6.98368 4.8307Z"
                                    fill="#959595" />
                            </svg>
                            <span>What’s This?</span>

                            <img src="{{ asset('frontend/images/bank-info.png') }}" alt="Card Info" class="img-fluid">
                        </div>
                    </div>

                </div>
                <div class="carInfo">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="get-form">
                                <label for="firstName">First Address</label>
                                <input type="text" wire:model.defer="first_address" class="form-control" id="firstName"
                                    placeholder="First Address">
                            </div>
                            @error('first_address')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="get-form">
                                <label for="lastName">Second Address</label>
                                <input type="text" wire:model.defer="second_address" class="form-control" id="lastName"
                                    placeholder="Second Address">
                            </div>
                            @error('second_address')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="get-form">
                                <label for="city">City</label>
                                <input type="text" wire:model.defer="city" class="form-control" id="city"
                                    placeholder="City">
                            </div>
                            @error('city')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="get-form">
                                <label for="postCode">Postcode</label>
                                <input type="text" wire:model.defer="zipcode" class="form-control number-font" id="postCode"
                                    placeholder="Postcode">
                            </div>
                            @error('zipcode')
                                <div class="get-form-error">
                                    <div class="get-form-error">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-4">
                            <button class="checkout-cart-button" type="submit"
                                wire:loading.class="d-none">Submit</button>
                            <x-button-loading wire:loading wire:target="submit" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @include('frontend.layouts.livewire.loading')
</div>
