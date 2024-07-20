<x-slot name="pageTitle">
    {{ __('customer.addresses.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('customer.addresses.title') }}
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
            <h3>@lang('customer.addresses.title')</h3>
        </div>
        <a href="{{ route('customer.addresses.create') }}" class="add-link">@lang('customer.addresses.create.title')</a>
    </div>
    <div class="managed-products-wrap">
        <div class="vender-products-edit customer-adress-main">
            <div class="row">
                @forelse ($addresses as $address)
                    @if ($address->isPrimary())
                        <div class="col-md-12">
                            <h3 class="customer-sub-head">
                                @lang('customer.addresses.primary.title')
                            </h3>
                        </div>
                    @endif
                    <div class="col-lg-6 col-md-12 col-sm-6">
                        <div class="customer-address-info">
                            <span class="adrs-edit">
                                <a href="{{ route('customer.addresses.show', $address->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a class="ms-2" href="#" @click="openConfirmationModal({{ $address->id }})" wire:key="address_{{ $address->id }}}}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </span>
                            <p>{{ $address->first_name }} {{ $address->last_name }}<br />
                                {{ $address->address_1 }}, {{ $address->address_2 }}
                                <br />
                                {{ $address->city }}, {{ $address->state->name }}
                                {{ $address->zip }}<br />
                                <span class="phone-d">+ {{ $address->phone }}</span><br />
                            </p>
                        </div>
                    </div>
                @empty
                    <p>@lang('global.no_records')</p>
                @endforelse
                <div class="text-center product-pagination">
                    {{ $addresses->links('frontend.layouts.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.livewire.loading')

    <x-modal.dialog form="$wire.delete(data.id)">
        <x-slot name="title">
            <div class="modal-header">
                <h4>
                    @lang('customer.addresses.delete.title')
                </h4>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="add-review-modal-wrap">
                <p>
                    @lang('customer.addresses.confirmation.msg')
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


@push('page_js')
    <script>
        $('.phone-d').text(function(i, text) {
            return text.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1 $2 $3 $4');
        });
    </script>
@endpush
