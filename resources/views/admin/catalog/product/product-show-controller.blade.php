<x-slot name="pageTitle">
    {{ __('catalog.product.edit.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="update">
        @include('admin.catalog.product.form')
</form>
