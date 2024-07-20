<x-slot:pageTitle>
    {{ html(__('cms.menu.builder.title', ['name' => $menu->name])) }}
</x-slot>

<x-slot:pageContainerClasses></x-slot>

<div>
    @if(! $item)
        <div class="text-right mb-4">
            <x-admin.components.button wire:click.prevent="newMenuItem">
                {{ __('cms.menu.builder.action.create') }}
            </x-admin.components.button>
        </div>
    @else
        <div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
            <div class="p-4 space-y-4">
                <div class="flex items-center space-x-4">
                    <form wire:submit.prevent="save" class="w-full space-x-4">
                        <div class="grid grid-cols-12">
                            <div class="col-span-6 md:col-span-6">
                                <x-admin.components.input.group for="title" label="{{ __('inputs.title') }}" :error="$errors->first('item.title')">
                                    <x-admin.components.input.text id="title" name="title" wire:model.defer="item.title" :error="$errors->first('item.title')" />
                                </x-admin.components.input.group>
                            </div>
                            <div class="col-span-6 md:col-span-6 ml-2">
                                <x-admin.components.input.group for="link" label="{{ __('inputs.url') }}" :error="$errors->first('item.link')">
                                    <x-admin.components.input.text id="link" name="link" wire:model.defer="item.link" :error="$errors->first('item.link')" />
                                </x-admin.components.input.group>    
                            </div>
                            <div class="col-span-12 md:col-span-12 mt-2 mb-2">
                                <x-admin.components.input.group for="title" label="{{ __('settings.full.image.label') }}" :error="$errors->first('thumbnail')">
                                    <div x-data="{
                                        thumbnail: @entangle('thumbnail')
                                    }" x-show="!thumbnail">
                                        <x-fileupload label="<span class='plus'>+</span>" :imagesHolder="null" wire:model="thumbnail" :filetypes="['image/*']" :multiple="false" />
                                    </div>
    
                                    @if ($thumbnail)
                                        <div class="feature-upload relative flex-wrap d-flex flex-row rounded border p-2">
                                            <div class="preview-img">
                                                <img class="img-fluid d-block mx-auto h-[150px] w-auto" src="{{ $this->thumbnailPreview }}" alt="">
                                            </div>
                                            <button wire:loading.attr="disabled" class="inline-flex absolute  top-2 right-2 justify-center items-center w-6 h-6 text-xs opacity-80 font-bold text-white bg-gray-700 rounded-full cursor-pointer" wire:target="removeThumbnail" wire:click.prevent="removeThumbnail">
                                                x
                                            </button>
                                        </div>
                                    @endif
                                </x-admin.components.input.group>
                            </div>
                            <div class="col-span-12 md:col-span-12">
                                <x-admin.components.button type="submit" theme="green" wire:loading.attr="disabled">
                                    @lang($item?->id ? 'global.save' : 'cms.menu.builder.action.create')
                                </x-admin.components.button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <br>
    @endif

    <div class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="p-4 space-y-4">

            <livewire:admin.cms.menu.item-tree
                :menu='$menu'
                key="tree_root"
            />
        </div>
    </div>
</div>