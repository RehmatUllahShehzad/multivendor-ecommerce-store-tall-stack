<div class="shadow sm:rounded-md">
    <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
        <header>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ __('global.image-manager.heading') }}
            </h3>
        </header>

        <div>
            <x-admin.components.input.fileupload wire:model="{{ $wireModel }}" :images="$images" :filetypes="$filetypes" :maxFiles="$maxFiles" :maxFileSize="$maxFileSize" :multiple="$multiple" />
        </div>

        @if ($errors->has($wireModel . '*'))
            <x-alert level="danger">{{ __('global.image-manager.generic_upload_error') }}</x-alert>
        @endif

        <div>
            <div wire:sort sort.options='{group: "images", method: "sort"}' class="relative mt-4 space-y-2">
                @foreach ($this->images as $image)
                    <div
                        class="flex items-center justify-between p-4 bg-white border rounded-md shadow-sm"
                        sort.item="images"
                        sort.id="{{ $image['sort_key'] }}"
                        wire:key="image_{{ $image['sort_key'] }}">
                        <div class="flex items-center w-full space-x-6">
                            @if (count($images) > 1)
                                <div class="cursor-move" sort.handle>
                                    <x-icon ref="dots-vertical" style="solid" class="text-gray-400 cursor-grab" />
                                </div>
                            @endif

                            <div>
                                <button type="button" wire:click="$set('images.{{ $loop->index }}.preview', true)">
                                    <img src="{{ $image['thumbnail'] }}" class="w-8 overflow-hidden rounded-md" />
                                </button>
                                {{-- <x-admin.components.modal wire:model="images.{{ $loop->index }}.preview">
                                    <img src="{{ $image['original'] }}">
                                </x-admin.components.modal> --}}
                            </div>

                            <div class="w-full">
                                <x-admin.components.input.text wire:model.defer="images.{{ $loop->index }}.caption" placeholder="Enter Alt. text" />
                            </div>

                            <div class="flex items-center ml-4 space-x-4">
                                <x-admin.components.tooltip text="Make primary">
                                    <x-admin.components.input.toggle :disabled="$image['primary']" :on="$image['primary']" wire:click.prevent="setPrimary('{{ $loop->index }}')" />
                                </x-admin.components.tooltip>

                                @if (!empty($image['id']))
                                    <x-admin.components.tooltip :text="__('global.image-manager.remake_transforms')">
                                        <button wire:click.prevent="regenerateConversions('{{ $image['id'] }}')" href="{{ $image['original'] }}" type="button">
                                            <x-icon ref="refresh" style="solid" class="text-gray-400 hover:text-indigo-500 hover:underline" />
                                        </button>
                                    </x-admin.components.tooltip>
                                @endif

                                <button
                                    type="button"
                                    wire:loading.attr="disabled"
                                    wire:target="removeImage"
                                    wire:click.prevent="removeImage('{{ $image['sort_key'] }}')"
                                    class="text-gray-400 hover:text-red-500 ">
                                    <x-icon ref="trash" style="solid" />
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
