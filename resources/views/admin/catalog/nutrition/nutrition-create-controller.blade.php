<x-slot name="pageTitle">
    {{ __('nutrition.create.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="create">
    <div class="grid grid-cols-12">
        @include('admin.catalog.nutrition.form')
    </div>
</form>
