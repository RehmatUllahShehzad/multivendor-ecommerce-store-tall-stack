<div {{ $attributes->merge(['class' => 'text-gray-700 dark:text-gray-400']) }}>
    @if ($slot->isEmpty())
        <strong>{{ __('notifications.sorry') }}</strong>
        {{ __('notifications.search-results.none') }}
    @else
        {{ $slot }}
    @endif
</div>
