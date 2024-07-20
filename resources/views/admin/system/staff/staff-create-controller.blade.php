<x-slot name="pageTitle">
    {{ __('staff.create.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="create">
    <div class="grid grid-cols-12">
        @include('admin.system.staff.form')
    </div>
</form>
