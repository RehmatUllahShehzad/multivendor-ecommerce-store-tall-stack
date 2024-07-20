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

                            <x-admin.components.input.group label="{{ __('inputs.title') }}" for="title"
                                :error="$errors->first('page.title')">
                                <x-admin.components.input.text wire:model.defer="page.title" id="title"
                                    :error="$errors->first('page.title')" />
                            </x-admin.components.input.group>

                            <x-admin.components.input.group label="{{ __('inputs.slug.label') }}" for="slug"
                                 :error="$errors->first('page.slug')">
                                <x-admin.components.input.text wire:model.defer="page.slug" id="slug"
                                    :error="$errors->first('page.slug')" />
                            </x-admin.components.input.group>

                            <x-admin.components.input.group label="{{ __('global.description') }}"
                                for="short_description" :error="$errors->first('page.short_description')">
                                <x-admin.components.input.richtext :initialValue="$page->short_description"
                                    wire:model.defer="page.short_description" name="featured" id="featured"
                                    :error="$errors->first('page.short_description')" />
                            </x-admin.components.input.group>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __($page->id ? 'Update Page' : 'Create Page') }}
                </button>
            </div>

        </div>
    </div>
</div>
@if ($page->id)
    <div class="bg-white border border-red-300 rounded shadow">
        <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
            {{ __('inputs.danger_zone.title') }}
        </header>
        <div class="p-6 space-y-4 text-sm">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6">
                    <strong>{{ __('This will be deleted') }}</strong>
                    <p class="text-xs text-gray-600">{{ __('catalog.page.form.danger_zone.instructions') }}</p>
                </div>
                <div class="col-span-9 lg:col-span-4">
                    <x-admin.components.input.text type="text" wire:model="deleteConfirm" />
                </div>
                <div class="col-span-3 text-right lg:col-span-2">
                    <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete" type="button">
                        {{ __('Delete') }}
                    </x-admin.components.button>
                </div>
            </div>
        </div>
    </div>
@endif
