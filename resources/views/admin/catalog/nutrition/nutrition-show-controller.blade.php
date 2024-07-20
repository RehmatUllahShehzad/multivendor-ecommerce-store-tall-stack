<x-slot name="pageTitle">
    {{ __('nutrition.edit.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="update">
    <div class="grid grid-cols-12">
        @include('admin.catalog.nutrition.form')
    </div>
</form>
