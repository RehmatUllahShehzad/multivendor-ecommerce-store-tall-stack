<?php

namespace App\Http\Livewire\Admin\Catalog;

use App\Models\Admin\Category;
use App\View\Components\Admin\Layouts\MasterLayout;
use Illuminate\Support\Collection;
use Livewire\Component;

class CollectionSearch extends Component
{
    /**
     * Should the browser be visible?
     *
     * @var bool
     */
    public bool $showBrowser = false;

    /**
     * The search term.
     *
     * @var string
     */
    public ?string $searchTerm = null;

    /**
     * Max results we want to show.
     *
     * @var int
     */
    public $maxResults = 50;

    /**
     * Any existing collections to exclude from selecting.
     *
     * @var \Illuminate\Support\Collection
     */
    public Collection $existing;

    /**
     * The currently selected collections.
     *
     * @var array<mixed>
     */
    public array $selected = [];

    /**
     * @return array<string,string>
     */
    public function getListeners()
    {
        return [
            'removed-existing-category' => 'removeExistingCollection',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function rules()
    {
        return [
            'searchTerm' => 'required|string|max:255',
        ];
    }

    /**
     * Return the selected collections.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSelectedModelsProperty()
    {
        return Category::whereIn('id', $this->selected)->get();
    }

    /**
     * Return the existing collection ids.
     *
     * @return Collection
     */
    public function getExistingIdsProperty(): Collection
    {
        return $this->existing->pluck('id');
    }

    /**
     * Listener for when show browser is updated.
     *
     * @return void
     */
    public function updatedShowBrowser()
    {
        $this->selected = [];
        $this->searchTerm = null;
    }

    /**
     * Add the collection to the selected array.
     *
     * @param  string|int  $id
     * @return void
     */
    public function selectCollection($id)
    {
        $this->selected[] = $id;
    }

    /**
     * Remove a collection from the selected collections.
     *
     * @param  string|int  $id
     * @return void
     */
    public function removeCollection($id)
    {
        $index = collect($this->selected)->search($id);
        unset($this->selected[$index]);
    }

    /**
     * Remove a collection from the selected collections.
     *
     * @param  string|int  $index
     * @return void
     */
    public function removeExistingCollection($index)
    {
        $this->existing->forget($index);
    }

    /**
     * Returns the computed search results.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator | void
     */
    public function getResultsProperty()
    {
        if (! $this->searchTerm) {
            return;
        }

        $items = Category::search($this->searchTerm)->paginate($this->maxResults);

        return $items;
    }

    public function triggerSelect(): void
    {
        $this->emit('categorySelected', $this->selected);
    }

    /**
     * Render the livewire component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('admin.catalog.collection-search')
            ->layout(MasterLayout::class, [
                'title' => 'slider',
                'description' => 'slider',
            ]);
    }
}
