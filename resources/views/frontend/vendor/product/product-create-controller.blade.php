<x-slot name="pageTitle">
    {{ __('vendor.product.create.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.product.create.title') }}
</x-slot>
<div class="vender-product-management-right position-relative">
    <form wire:submit.prevent="submit">
        @include('frontend.vendor.product.form')
    </form>    
</div>
