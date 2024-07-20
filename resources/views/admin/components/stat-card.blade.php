<div
    class="{{ $attributes->merge(['class' => 'flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800'])->get('class') }}">
    <div
        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
        @if ($attributes->has('icon') || !empty($icon))
            <x-icon ref="{!! $attributes->get('icon') !!}" style="solid" class="{{ $attributes->get('icon-class') }}" />
        @else
            <x-icon ref="user-group" style="solid" class="flex items-center justify-center" />
        @endif
    </div>
    <div>
        <p
            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $attributes->get('label') }}
        </p>
        <p
            class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $attributes->get('value') }}
        </p>
    </div>
</div>
