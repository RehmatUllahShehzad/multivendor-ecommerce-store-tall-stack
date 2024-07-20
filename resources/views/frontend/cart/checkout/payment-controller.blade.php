<x-slot name="currentStep">
    {{ $currentStep }}
</x-slot>
<x-slot name="title">
    Payment Method
</x-slot>
<div>
    <section>
        <div class="container">
            <form wire:submit.prevent="setPaymentMethod" >
            <div class="select-card-main w-75 mx-auto pt-3 pt-md-5" >
                <h2 class="pb-4">Select a Saved Card</h2>
                <div class="select-card bg-light w-100">
                    @foreach($paymentMethods as $paymentMethod)
                        <div class="form-check saved-cards custom-radio border-bottom p-0 m-0">
                            <input class="form-check-input" type="radio" wire:model.defer="paymentMethod" value="{{ $paymentMethod->id }}"  name="payment" id="flexRadioDefault-{{$paymentMethod->id}}" >
                            <label class="form-check-label radio-label w-100 position-relative p-4" for="flexRadioDefault-{{ $paymentMethod->id }}">
                                <div class="select-bar d-flex justify-content-between align-items-center">
                                    <span>{{ getFormattedCardNumber($paymentMethod->card_number) }}</span>
                                    <div class="card-img">
                                        <img src="{{ asset('frontend/images/american-card-logo.png')}}" class="img-fluid">
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                    <div class="add-new p-3 d-flex justify-content-end" x-data>
                        <a href="javascript:void()" class="popup-btn" @click="$dispatch('showmodal')">
                            Add a new card
                        </a>
                    </div>
                </div>
                <div class="modal-footer w-100 px-0 border-0">
                    <button type="submit" class="theme-button">Continue</button>
                </div>
            </form>
            </div>
            <!-- Modal -->
            <x-checkout-dialog form="submit" title='Add new Payment Method'>
                <x-slot name="content">
                    @include('frontend.cart.inc.payment-form')
                </x-slot>
            </x-checkout-dialog>
        </div>
    </section>
</div>
