<x-slot name="pageTitle">
    {{ __('customer.payment_methods.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('customer.payment_methods.title') }}
</x-slot>
<div class="vender-product-management-right" x-data="{
    data: {
        id: null
    },

    openConfirmationModal(id) {
        this.data.id = id;
        this.$dispatch('open-modal');
    }
}">
    <div class="product-manage-heading">
        <div class="header-select">
            <h3>@lang('customer.payment_methods.title')</h3>
        </div>
        <a href="{{ route('customer.payment.create') }}" class="add-link">@lang('customer.payment_methods.create.title')</a>
    </div>
    <div class="managed-products-wrap">
        <div class="vender-products-edit customer-adress-main">
            <div class="row">
                @forelse ($paymentMethods as $paymentMethod)
                    @if ($paymentMethod->isPrimary())
                        <div class="col-md-12">
                            <h3 class="customer-sub-head">
                                @lang('global.primary')
                            </h3>
                        </div>
                    @endif
                    <div class="col-sm-6">
                        <div class="customer-address-info">
                            <span class="adrs-edit">
                                <a class="ms-2" href="#" @click="openConfirmationModal({{ $paymentMethod->id }})" wire:key="paymentMethod_{{ $paymentMethod->id }}}}">
                                    <i class="fas fa-trash-alt" wire:loading.remove wire:target="delete({{ $paymentMethod->id }})">
                                    </i>
                                    <x-button-loading wire:loading wire:target="delete({{ $paymentMethod->id }})" />
                                </a>
                            </span>
                            <p>
                                <span>@lang('customer.payment_methods.card.name.label')
                                    <span class="ms-3">
                                        {{ $paymentMethod->name }}
                                    </span>
                                </span> <br />
                                <span>@lang('customer.payment_methods.card.number.label')
                                    <span class="ms-3 payment-number">
                                        {{ getFormattedCardNumber($paymentMethod->card_number) }}
                                    </span>
                                </span><br />
                                <span>@lang('customer.payment_methods.card.expiry.label')
                                    <span class="ms-3 payment-number">
                                        {{ $paymentMethod->exp_month }}-{{ $paymentMethod->exp_year }}
                                    </span>
                                </span>
                            </p>
                        </div>
                    </div>
                @empty
                    <p>@lang('global.no_records')</p>
                @endforelse
                <div class="text-center product-pagination">
                    {{ $paymentMethods->links('frontend.layouts.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.livewire.loading')

    <x-modal.dialog form="$wire.delete(data.id)">
        <x-slot name="title">
            <div class="modal-header">
                <h4>
                    @lang('customer.payment_methods.delete.title')
                </h4>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="add-review-modal-wrap">
                <p>
                    @lang('customer.payment_methods.confirmation.msg')
                </p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="new-near-you-button vice-versa" type="button" @click="$dispatch('close')">@lang('global.cancel')</button>
            <button class="new-near-you-button" wire:loading.attr="disabled" type="submit">@lang('global.confirm')
                <x-button-loading wire:loading />
            </button>
        </x-slot>
    </x-modal.dialog>

</div>
