<div class="flex flex-col w-full">
    <div class="grid grid-cols-2 gap-4">
        <x-admin.components.card heading="Customer Information">
            <form method="POST" wire:submit.prevent="updateCustomer" class="flex justify-between flex-col">
                <div class="grid grid-cols-1 gap-4">
                    <x-admin.components.input.group label="{{ __('inputs.firstname') }}" for="firstname" :error="$errors->first('customer.first_name')">
                        <x-admin.components.input.text wire:model.defer="customer.first_name" name="firstname" id="firstname" :error="$errors->first('customer.first_name')" />
                    </x-admin.components.input.group>
                    <x-admin.components.input.group label="{{ __('inputs.lastname') }}" for="lastname" :error="$errors->first('customer.last_name')">
                        <x-admin.components.input.text wire:model.defer="customer.last_name" name="lastname" id="lastname" :error="$errors->first('customer.last_name')" />
                    </x-admin.components.input.group>
                    <x-admin.components.input.group label="{{ __('inputs.username') }}" for="name" :error="$errors->first('customer.username')">
                        <x-admin.components.input.text wire:model.defer="customer.username" name="name" id="name" :error="$errors->first('customer.username')" />
                    </x-admin.components.input.group>
                    <x-admin.components.input.group label="{{ __('inputs.email') }}" for="email">
                        <x-admin.components.input.text value="{{ $this->customer->email }}" type="email" name="email" readonly id="email"/>
                    </x-admin.components.input.group>
                </div>
                <div class="px-4 py-3 text-right rounded sm:px-6 mt-3">
                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('customer.edit.update_btn') }}
                    </button>
                </div>
            </form>
        </x-admin.components.card>
        {{-- Vendor Form --}}
        @if($customer->isVendor())
        <livewire:admin.customer.vendor-show-controller :customer="$customer" />
        @else
            <x-admin.components.card heading="Vendor Information">
                {{ __('vendor.not_vendor') }}
            </x-admin.components.card>
        @endif
    </div>

    @if ($customer->vendorRequests()->exists())
        <div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg mt-10">
            <div class="p-4 space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="grid grid-cols-12 w-full space-x-4">
                        <div class="col-span-8 md:col-span-8">
                            <header>
                                {{ __('vendor.request.title') }}
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <x-admin.components.table class="w-full whitespace-no-wrap p-2">
                <x-slot name="head">
                    <x-admin.components.table.heading>
                        {{ __('global.sr_no') }}
                    </x-admin.components.table.heading>
                    <x-admin.components.table.heading>
                        {{ __('global.status') }}
                    </x-admin.components.table.heading>
                    <x-admin.components.table.heading>
                        {{ __('global.date') }}
                    </x-admin.components.table.heading>
                    <x-admin.components.table.heading>
                        Action
                    </x-admin.components.table.heading>
                </x-slot>
                <x-slot name="body">
                    @foreach ($vendorRequests as $vendorRequest)
                        <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                            <x-admin.components.table.cell>
                                {{ $loop->iteration }}
                            </x-admin.components.table.cell>
                            <x-admin.components.table.cell>
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $vendorRequest->status->name }}
                                </span>
                            </x-admin.components.table.cell>
                            <x-admin.components.table.cell>
                                {{ $vendorRequest->created_at->format('m/d/Y') }}
                            </x-admin.components.table.cell>
                            <x-admin.components.table.cell>
                                @if ($vendorRequest->status->name == 'Pending')
                                    <x-admin.components.button wire:loading type="button" wire:key="vendor_request_{{ $vendorRequest->id }}" @click="$dispatch('showslideover', {{ $vendorRequest->id }})">
                                        {{ __('vendor.request.update_btn') }}
                                        @include('admin.layouts.livewire.button-loading')
                                    </x-admin.components.button>
                                @endif
                            </x-admin.components.table.cell>

                        </x-admin.components.table.row>
                    @endforeach
                    <x-vendor-request-status-action />
                </x-slot>
            </x-admin.components.table>
        </div>
    @endif

</div>
