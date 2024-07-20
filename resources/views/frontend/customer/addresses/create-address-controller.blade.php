<x-slot name="pageTitle">
    {{ __('customer.addresses.create.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('customer.addresses.create.title') }}
</x-slot>

<div class="vender-product-management-right">
    <div class="product-manage-heading toggling-btn-wrap">
        <div class="header-select">
            <h3>@lang('customer.addresses.create.title')</h3>
        </div>
    </div>
    <div class="managed-products-wrap">
        <div class="vender-products-edit">
            <form wire:submit.prevent="submit">
                @include('frontend.customer.addresses.form')
            </form>
        </div>
    </div>
</div>
