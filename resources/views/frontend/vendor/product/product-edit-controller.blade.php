<x-slot name="pageTitle">
    {{ __('vendor.product.edit.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.product.edit.title') }}
</x-slot>
<div class="vender-product-management-right position-relative">
    <form wire:submit.prevent="update">
        @include('frontend.vendor.product.form')
    </Form>
</div>
