<div class="py-12 pb-24 lg:grid lg:grid-cols-12 lg:gap-x-12" wire:loading.class="opacity-50">
    <div class="sm:px-6 lg:px-0 lg:col-span-12">
        <div class="space-y-6">

            <div class="space-y-4">
                <div class="shadow sm:rounded-md">
                    <div class="flex-col space-y-4 bg-white rounded px-4 py-5 sm:p-6">
                        <header>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Details
                            </h3>
                        </header>
                        <div class="space-y-4">

                            <x-admin.components.input.group label="{{ __('inputs.name') }}" for="name"
                                :error="$errors->first('category.name')">
                                <x-admin.components.input.text wire:model.defer="category.name" name="name"
                                    id="name" :error="$errors->first('category.name')" />
                            </x-admin.components.input.group>

                            <x-admin.components.input.group label="{{ __('inputs.featured') }}" for="featured"
                                :error="$errors->first('category.featured')">
                                <x-admin.components.input.toggle :onValue="1"
                                    wire:model.defer="category.is_featured" name="featured" id="featured"
                                    :error="$errors->first('category.is_featured')" />
                            </x-admin.components.input.group>
                        </div>
                    </div>
                </div>
            </div>

            <div id="images">
                <x-admin.components.image-manager :existing="$images" :maxFileSize="3" :maxFiles="1"
                    :multiple="false" model="imageUploadQueue" :filetypes="['image/*']" />
                @error('images')
                    <div class="space-y-1 text-center">
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
                </div>

            <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __($category->id ? 'catalog.categories.show.save_btn' : 'catalog.categories.create.title') }}
                </button>
            </div>

        </div>
    </div>
</div>
@if ($category->id)
    <div class="bg-white border border-red-300 rounded shadow">
        <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
            {{ __('inputs.danger_zone.title') }}
        </header>
        <div class="p-6 space-y-4 text-sm">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6">
                    <strong>{{ __('catalog.category.form.danger_zone.label') }}</strong>
                    <p class="text-xs text-gray-600">{{ __('catalog.category.form.danger_zone.instructions') }}</p>
                </div>
                <div class="col-span-9 lg:col-span-4">
                    <x-admin.components.input.text type="text" wire:model="deleteConfirm" />
                </div>
                <div class="col-span-3 text-right lg:col-span-2">
                    <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete" type="button">
                        {{ __('global.delete') }}
                    </x-admin.components.button>
                </div>
            </div>
        </div>
    </div>
@endif
