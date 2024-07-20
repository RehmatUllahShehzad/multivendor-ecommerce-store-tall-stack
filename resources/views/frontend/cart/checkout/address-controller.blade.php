<x-slot name="currentStep">
    {{ $currentStep }}
</x-slot>
<x-slot name="title">
    Cart Addresses
</x-slot>
<div>
    <section>
        <div class="container">
            <div class="shopping-cart-header">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <div class="cart-header-title">
                            <h2 class="mb-0">{{ $currentStep == 'shipping' ? 'Shipping Address' : 'Billing Address' }}</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cart-header-button text-end">
                            <div class="proceed-button-wrap">
                                <p>Subtotal (
                                    <livewire:frontend.cart.counter /> items): $<span>{{ $this->cart->subTotal }}</span>
                                </p>
                                <div class="prceed-btn">
                                    <a class="theme-button button" href="{{ $currentStep == 'billing' ? route('checkout.payment') : route('checkout.billing') }}">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            @if ($currentStep == 'billing')
                <div class="same-as-shipping">
                    <div class="custom-form-group">
                        <input wire:model="billingSameAsShipping" value="true" type="checkbox" id="sameAddress">
                        <label for="sameAddress">Billing address is same as shipping address</label>
                    </div>
                </div>
            @endif
            @if (!$billingSameAsShipping)
                <div class="addresses-list-wrap">
                    <div class="addresses-list">
                        <div class="row">
                            @foreach ($addresses as $address)
                                @php($selected = $this->selected_user_address_id == $address->id)
                                <div class="col col-lg-4 col-md-6 col-12" wire:click.prevent="set{{ ucfirst($currentStep) }}Address({{ $address->id }})">
                                    <div class="address-box mt-0">
                                        <label for="address">
                                            <input type="radio" name="selectedAddress" id="address" class="d-none">
                                            <div class="inner-box d-flex {{ $selected ? 'selected' : '' }}">
                                                <h5 class="boxHeader {{ $address->is_primary || $selected ? 'd-flex' : '' }} justify-content-between">
                                                    <b>{{ $address->is_primary ? 'Primary Address' : '' }}</b>

                                                    @if ( $selected )
                                                        <i class="fa fa-check-circle"></i>
                                                    @endif
                                                </h5>
                                                <div class="innerContainer latlng">
                                                    <div class="addressLabelWrapper d-flex justify-content-between align-items-center">
                                                        <span class="addressLabel">
                                                            <b>{{ $address->address_type->value }}</b>
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </span>
                                                        <div class="addressListToolTip">
                                                            <div class="tooltipContainer">
                                                                <i class="fa fa-ellipsis-h openToolotip"></i>
                                                                <div class="tooltipContentWrapper">
                                                                    <div class="tooltip-drop">
                                                                        <div class="tooltipText">
                                                                            <div class="tooltipWrapper">
                                                                                <a class="option d-flex align-items-center w-100 border-bottom" wire:click="editAddress({{ $address->id }})" aria-label="Edit" class="">
                                                                                    <i class="fa fa-edit"></i>
                                                                                    <span>Edit</span>
                                                                                </a>


                                                                                <a class="option d-flex align-items-center w-100 border-bottom" wire:click="setPrimaryAddress({{ $address->id }})" aria-label="Delete">
                                                                                    <i class="fa fa-check-circle"></i>
                                                                                    <span>Set as primary</span>
                                                                                </a>

                                                                                <a wire:click.prevent.stop="delete({{ $address->id }})" class="option d-flex align-items-center w-100 border-bottom" aria-label="Delete">
                                                                                    <i class="fa fa-trash"></i>
                                                                                    <span>Delete</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="addressDetailsContainer">
                                                        <div class="addressRow d-flex">
                                                            <span class="addressColumn addressColumnLeft">Name</span>
                                                            <span class="addressColumn fullName">
                                                                <b>{{ $address->first_name }} {{ $address->last_name }}</b>
                                                            </span>
                                                        </div>
                                                        <div class="addressRow d-flex"><span class="addressColumn addressColumnLeft">Address</span>
                                                            <div class="addressColumn fullAddress">{{ $address->address_1 }}, {{ $address->address_2 }}</div>
                                                        </div>
                                                        <div class="addressRow d-flex"><span class="addressColumn addressColumnLeft">Phone #</span>
                                                            <div class="addressColumn phoneNoWrapper verifiedLabel"><span class="honeNumber phone-d">+ {{ $address->phone }}</span>
                                                                <div class="verificationStatus">
                                                                    <i class="icon icon-cross unchecked" style="color: rgb(64, 69, 83); font-size: 13px;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col col-lg-4 col-md-6 col-12">
                                <div class="addNewAddressCtr" x-data>
                                    <button type="button" @click="$dispatch('showmodal')" class="addNewAddress text-center">+ Add a new address</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal -->
    <x-checkout-dialog form="saveAddress" title='Add new Address'>
        <x-slot name="content">
            @include('frontend.cart.inc.address-form')
        </x-slot>
    </x-checkout-dialog>
</div>

@push('page_js')
    <script>
        $('.phone-d').text(function(i, text) {
            return text.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1 $2 $3 $4');
        });
    </script>
@endpush
