<div class="space-y-2" wire:sort sort.options='{group: "{{ $sortGroup }}", method: "sort"}'>
    @foreach ($nodes as $node)
        <div
            wire:key="node_{{ $node['id'] }}"
            sort.item="{{ $sortGroup }}"
            sort.id="{{ $node['id'] }}"
            @if ($node['parent_id']) sort.parent="{{ $node['parent_id'] }}" @endif>
            <div
                class="flex items-center">
                <div wire:loading wire:target="sort">
                    <x-icon ref="refresh" style="solid" class="w-5 mr-2 text-gray-300 rotate-180 animate-spin" />
                </div>

                <div wire:loading.remove wire:target="sort">
                    <div sort.handle class="cursor-grab">
                        <x-icon ref="selector" style="solid" class="mr-2 text-gray-400 hover:text-gray-700" />
                    </div>
                </div>

                <div class="flex items-center justify-between w-full p-3 text-sm bg-white border border-transparent rounded shadow-sm sort-item-element hover:border-gray-300">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center">
                            @if ($node['thumbnail'])
                                <img class="w-6 rounded" src="{{ $node['thumbnail'] }}" />
                            @else
                                <x-icon ref="photograph" class="w-6 mx-auto text-gray-300" />
                            @endif
                            <div class="ml-2 truncate">{{ $node['name'] }}</div>
                        </div>

                        @if ($node['children_count'])
                            <div class="text-sm text-gray-400 w-18">{{ $node['children_count'] }}</div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end w-16">
                        @if ($node['children_count'])
                            <button type="button" wire:loading.attr="disabled" wire:targe="toggle" wire:click.prevent="toggle({{ $node['id'] }})">
                                <div class="transition-transform" :class="{
                                    '-rotate-90 ': {{ count($node['children']) }}
                                }">
                                    <div wire:loading.remove wire:target="toggle">
                                        <x-icon ref="chevron-left" style="solid" />
                                    </div>
                                    <div wire:loading wire:target="toggle">
                                        <x-icon ref="refresh" style="solid" class="w-5 mr-2 text-gray-300 rotate-180 animate-spin" />
                                    </div>
                                </div>
                            </button>
                        @endif

                        <x-admin.components.dropdown.index minimal>
                            <x-slot name="options">
                                <x-admin.components.dropdown.link :href="route('admin.catalog.category.show', [
                                    'category' => $node['id'],
                                ])" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 border-b hover:bg-gray-50">
                                    {{ __('catalog.categories.edit.title') }}
                                    <x-icon ref="pencil" style="solid" class="w-4" />
                                </x-admin.components.dropdown.link>
                            </x-slot>
                        </x-admin.components.dropdown.index>
                    </div>
                </div>
            </div>
            @if (count($node['children']))
                <div class="py-4 pl-2 pr-4 mt-2 space-y-2 border-l ml-7">
                    <livewire:admin.catalog.category.category-tree
                        :nodes="$node['children']"
                        :sortGroup="'children_' . $node['id']"
                        :key="'tree' . $node['id']" />
                </div>
            @endif
        </div>
    @endforeach
</div>
