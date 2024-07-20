<tr {{ $attributes->merge(['class' => 'bg-white even:bg-gray-50 dark:bg-gray-700 dark:even:bg-gray-800 dark:border-none']) }} wire:loading.class.delay="opacity-50">
    {{ $slot }}
</tr>
