<x-admin.components.card :heading="$customer->vendor ? __('vendor.title_info') : __('vendor.become_title')">
    <form method="POST" wire:submit.prevent="updateVendor" class="flex justify-around flex-col">
        <div class="grid grid-cols-1 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.name') }}" for="name" :error="$errors->first('customer.name')">
                <x-admin.components.input.text wire:model.defer="vendor.vendor_name" name="name" id="name" :error="$errors->first('customer.name')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.company_name.label') }}" for="company_name.label" :error="$errors->first('vendor.company_name')">
                <x-admin.components.input.text wire:model.defer="vendor.company_name" type="text" name="company_name.label" id="company_name.label" :error="$errors->first('vendor.company_name')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.company_phone.label') }}" for="company_phone.label" :error="$errors->first('vendor.company_phone')">
                <x-admin.components.input.text wire:model.defer="vendor.company_phone" type="text" name="company_phone.label" id="company_phone.label" :error="$errors->first('vendor.company_phone')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.company_address.label') }}" for="company_address.label" :error="$errors->first('vendor.company_address')">
                <x-admin.components.input.text wire:model.defer="vendor.company_address" type="text" name="company_address.label" id="company_address.label" :error="$errors->first('vendor.company_address')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.vendor_bio.label') }}" for="vendor_bio.label" :error="$errors->first('vendor.bio')">
                <x-admin.components.input.text wire:model.defer="vendor.bio" type="text" name="vendor_bio.label" id="vendor_bio.label" :error="$errors->first('vendor.bio')" />
            </x-admin.components.input.group>
        </div>
        <div class="px-4 py-3 text-right rounded sm:px-6 mt-3">
            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __($customer->vendor ? 'vendor.edit.update_btn' : 'vendor.create_btn') }}
            </button>
        </div>
    </form>
</x-admin.components.card>
