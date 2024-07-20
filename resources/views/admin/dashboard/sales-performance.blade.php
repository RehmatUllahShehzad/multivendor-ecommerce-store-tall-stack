<div class="py-4 mx-auto mt-8">
    <div class="flex flex-row gap-x-8">
        <div class="w-full">
            <div class="p-4 bg-white rounded-lg h-96">
                <div class="flex flex-row justify-between w-full">
                    <h3 class="mt-4 ml-4 text-lg font-semibold text-gray-900">
                        {{ __('dashboard.sales_performance') }}
                    </h3>
                    <div class="col-span-4 text-right mr-0 md:col-span-4">
                        <div class="flex items-center space-x-4">
                            <x-admin.components.input.datepicker wire:model="range.from" readonly="readonly" />
                            <span class="text-xs font-medium text-gray-500 uppercase">{{ __('global.to') }}</span>
                            <x-admin.components.input.datepicker wire:model="range.to" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="h-80">
                    <x-admin.components.apex-chart :key="$key" :options="$options" />
                </div>
            </div>
        </div>
    </div>
</div>
