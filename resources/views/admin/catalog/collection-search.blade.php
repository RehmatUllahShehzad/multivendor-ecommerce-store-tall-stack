<div x-data>
    <x-admin.components.button wire:loading wire:click.prevent="$set('showBrowser', true)" type="button" @click="$dispatch('showslideover')">
        {{ __('catalog.categories-search.btn') }}
        @include('admin.layouts.livewire.button-loading')
    </x-admin.components.button>
    <x-admin.components.slideover title="Search by name">
        <div class="space-y-4" x-data="{
            tab: 'search'
        }">
            <div>
                <nav class="flex space-x-4" aria-label="Tabs">
                    <button x-on:click.prevent="tab = 'search'" class="px-3 py-2 text-sm font-medium rounded-md"
                        :class="{
                            'bg-indigo-100 text-indigo-700': tab == 'search',
                            'text-gray-500 hover:text-gray-700': tab != 'search'
                        }">
                        {{ __('catalog.categories-search.first_tab') }}
                    </button>

                    <button class="px-3 py-2 text-sm font-medium rounded-md" @click.prevent="tab = 'selected'"
                        :class="{
                            'bg-indigo-100 text-indigo-700': tab == 'selected',
                            'text-gray-500 hover:text-gray-700': tab != 'selected'
                        }">
                        {{ __('catalog.categories-search.second_tab') }} ({{ $this->selectedModels->count() }})
                    </button>
                </nav>
            </div>

            <div x-show="tab == 'search'">
                <x-admin.components.input.text wire:model.debounce.600ms="searchTerm" />
                <div wire:loading.class="hidden" wire:target="searchTerm">
                    @if ($this->searchTerm)
                        @if ($this->results->total() > $maxResults)
                            <span class="block p-3 my-2 text-xs text-blue-600 rounded bg-blue-50">
                                {{ __('catalog.categories-search.max_results_exceeded', [
                                    'max' => $maxResults,
                                    'total' => $this->results->total(),
                                ]) }}
                            </span>
                        @endif
                        <div class="mt-4 space-y-1">
                            @forelse($this->results as $collection)
                                <div class="flex w-full items-center justify-between rounded shadow-sm text-left border px-2 py-2 text-sm @if ($this->existingIds->contains($collection->id)) opacity-25 @endif">
                                    <div class="truncate">
                                        {{ $collection->name }} {{ $collection->deleted_at }}
                                        <span class="block pr-32 text-xs text-gray-400 truncate">{{ $collection->breadcrumb }}</span>
                                    </div>
                                    @if (!$this->existingIds->contains($collection->id))
                                        @if (collect($this->selected)->contains($collection->id))
                                            <button class="px-2 py-1 text-xs text-red-700 border border-red-200 rounded shadow-sm hover:bg-red-50" wire:click.prevent="removeCollection('{{ $collection->id }}')">
                                                {{ __('global.deselect') }}
                                            </button>
                                        @else
                                            <button class="px-2 py-1 text-xs text-blue-700 border border-blue-200 rounded shadow-sm hover:bg-blue-50" wire:click.prevent="selectCollection('{{ $collection->id }}')">
                                                {{ __('global.select') }}
                                            </button>
                                        @endif
                                    @else
                                        <span class="text-xs">
                                            {{ __('catalog.categories-search.exists_in_collection') }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                {{ __('catalog.categories-search.no_results') }}
                            @endforelse
                        </div>
                    @else
                        <div class="px-3 py-2 mt-4 text-sm text-gray-500 bg-gray-100 rounded">
                            {{ __('catalog.categories-search.pre_search_message') }}
                        </div>
                    @endif
                </div>

                <div class="hidden" wire:loading.block wire:target="searchTerm">
                    Loading ...
                </div>
            </div>

            <div x-show="tab == 'selected'" class="space-y-2">
                @forelse($this->selectedModels as $collection)
                    <div class="flex items-center justify-between w-full px-2 py-2 text-sm text-left border rounded shadow-sm " wire:key="selected_{{ $collection->id }}">
                        <div class="truncate max-w-64">
                            {{ $collection->name }}
                            <span class="block pr-32 text-xs text-gray-400">{{ $collection->breadcrumb }}</span>
                        </div>
                        <button class="px-2 py-1 text-xs text-red-700 border border-red-200 rounded shadow-sm hover:bg-red-50" wire:click.prevent="removeCollection('{{ $collection->id }}')">
                            {{ __('global.deselect') }}
                        </button>
                    </div>
                @empty
                    <div class="px-3 py-2 mt-4 text-sm text-gray-500 bg-gray-100 rounded">
                        {{ __('catalog.categories-search.select_empty') }}
                    </div>
                @endforelse
            </div>
        </div>

        <x-slot name="footer">
            <x-admin.components.button wire:click.prevent="triggerSelect" x-on:click="show = false">
                {{ __('catalog.categories-search.commit_btn') }}
                </x-admin.componennts.button>
        </x-slot>

        <x-slot name="content">
            <x-admin.components.loading wire:loading wire:target="$set('showBrowser', true)" />
        </x-slot>

    </x-admin.components.slideover>
</div>
