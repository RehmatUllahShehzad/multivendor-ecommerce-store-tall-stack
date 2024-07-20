<x-slot name="pageTitle">
    {{ __('staff.edit.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="update">
    <div class="grid grid-cols-12">
        @include('admin.system.staff.form')
    </div>
</form>
