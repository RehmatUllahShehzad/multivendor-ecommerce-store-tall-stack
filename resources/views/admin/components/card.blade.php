<div {{ $attributes->merge(['class' => 'shadow sm:rounded-md']) }}>
    <div class="flex-col px-4 py-5 space-y-4 bg-white rounded-md sm:p-6 h-full">
        <header>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $heading }}
            </h3>
        </header>

        <div class="space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
