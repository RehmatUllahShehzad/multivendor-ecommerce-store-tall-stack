<div class="row">
    <div class="col-md-6">
        <div class="float-input-group pb-3">
            <div class="input-group has-validation">
                <label for="noc" class="form-label">Name on Card</label>
                <input type="text" wire:model.defer="name" class="form-control rounded-0 shadow-none" id="noc" placeholder="Name on Card" aria-describedby="noc">
                @error('name')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="float-input-group pb-3">
            <div class="input-group has-validation">
                <label for="cn" class="form-label">Card Number</label>
                <input type="text" wire:model.defer="card_number" class="form-control number-font rounded-0 shadow-none mask_us_credit_card" id="cn" placeholder="Card Number" aria-describedby="cn">
                @error('card_number')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="float-input-group pb-3 position-relative">
            <select wire:model.defer="exp_month" class="form-select rounded-0" id="month" aria-label="Floating label select example">
                <option value="" disabled>Choose Month</option>
                @foreach (get_12_months() as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <label for="month">MM</label>
            @error('exp_month')
                <div class="get-form-error mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="float-input-group pb-3 position-relative">
            <select wire:model.defer="exp_year" class="form-select number-font rounded-0" id="year" aria-label="Floating label select example">
                <option value="" disabled>Choose Year</option>
                @foreach (get_next_years(10, true) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <label for="year">YY</label>
            @error('exp_year')
                <div class="get-form-error mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="float-input-group pb-3">
            <div class="input-group has-validation">
                <label for="cvc" class="form-label">CVC</label>
                <input wire:model.defer="cvc" type="text" class="form-control number-font rounded-0 shadow-none" id="cvc" placeholder="CVC" aria-describedby="cvc">
                @error('cvc')
                    <div class="get-form-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="cvc-info d-flex align-items-center h-75 position-relative">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.9501 2.05015C9.2164 -0.68323 4.78413 -0.683535 2.05015 2.05015C-0.683535 4.78383 -0.68323 9.21609 2.05015 11.9501C4.78383 14.6832 9.21609 14.6835 11.9501 11.9501C14.6835 9.21609 14.6832 4.78413 11.9501 2.05015ZM7.91286 10.0436C7.91286 10.5479 7.50412 10.9567 6.99981 10.9567C6.4955 10.9567 6.08676 10.5479 6.08676 10.0436V6.39141C6.08676 5.8871 6.4955 5.47836 6.99981 5.47836C7.50412 5.47836 7.91286 5.8871 7.91286 6.39141V10.0436ZM6.98368 4.8307C6.45776 4.8307 6.10715 4.45817 6.1181 3.9983C6.10715 3.51621 6.45776 3.15494 6.99433 3.15494C7.53121 3.15494 7.87086 3.51651 7.88212 3.9983C7.88182 4.45817 7.53151 4.8307 6.98368 4.8307Z"
                    fill="#959595" />
            </svg>
            <span class="ms-2">What's This?</span>
            <img src="{{ asset('frontend/images/bank-info.png') }}" alt="" class="img-fluid position-absolute">
        </div>
    </div>
</div>
<div class="modal-footer border-0">
    <button type="submit" class="theme-button">Submit
        <x-button-loading wire:loading wire:target="submit" />
    </button>
</div>
