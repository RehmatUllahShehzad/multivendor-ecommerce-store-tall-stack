@php
    $id = $id ?? md5($attributes->wire('model'));
    
    switch ($maxWidth ?? '2xl') {
        case 'sm':
            $maxWidth = 'sm:max-w-sm';
            break;
        case 'md':
            $maxWidth = 'sm:max-w-md';
            break;
        case 'lg':
            $maxWidth = 'sm:max-w-lg';
            break;
            $maxWidth = 'sm:max-w-xl';
            break;
        case '2xl':
        default:
            $maxWidth = 'sm:max-w-2xl';
            break;
    }
@endphp

<div x-data="{
    show: false,
    init() {
        this.$watch('show', show => jQuery(this.$el).modal(show ? 'show' : 'hide'))
    },
}" 
    x-init="init" 
    x-on:close.stop="show = false" 
    {{-- x-on:submit="show = false" --}}
    x-on:keydown.escape.window="show = false" id="{{ $id }}" 
    x-on:open-modal.window="show = true" 
    x-on:close-modal.window="show = false" 
    wire:ignore.self class="modal"
    >

    <div class="modal-dialog modal-dialog-centered">
        {{ $slot }}
    </div>
</div>
