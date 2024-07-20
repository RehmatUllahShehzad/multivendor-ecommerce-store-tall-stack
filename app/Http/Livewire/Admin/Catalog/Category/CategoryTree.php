<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\MapCategories;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Category;
use Illuminate\Contracts\View\View;

class CategoryTree extends CatalogAbstract
{
    use Notifies;
    use MapCategories;

    /**
     * The nodes for the tree.
     *
     * @var array<mixed>
     */
    public array $nodes;

    /**
     * The sort group.
     *
     * @var string
     */
    public $sortGroup;

    /**
     * @var array<mixed>
     */
    protected $listeners = [
        'collectionMoved',
        'collectionsChanged',
    ];

    /**
     * Toggle children visibility.
     *
     * @param  int  $nodeId
     * @return void
     */
    public function toggle($nodeId)
    {
        $index = collect($this->nodes)->search(function ($node) use ($nodeId) {
            return $node['id'] == $nodeId;
        });

        $nodes = [];

        if (! count($this->nodes[$index]['children'])) {
            $nodes = $this->mapCategories(
                Category::whereParentId($nodeId)->withCount('children')->defaultOrder()->get()
            );
        }

        $this->nodes[$index]['children'] = $nodes;
    }

    /**
     * Sort the categories.
     *
     * @param  array<mixed>  $payload
     * @return void
     */
    public function sort($payload)
    {
        /** @phpstan-ignore-next-line */
        $ids = collect($payload['items'])->pluck('id')->toArray();

        $objectIdPositions = array_flip($ids);

        $models = Category::withCount('children')->findMany($ids)->sortBy(function ($model) use ($objectIdPositions) {
            return $objectIdPositions[$model->getKey()];
        })->values();

        $models->each(function ($category, $index) {
            $category->setOrder($index);
        });

        $this->nodes = $this->mapCategories($models);

        $this->notify(
            __('notifications.categories.reordered')
        );
    }

    /**
     * Remove a collection.
     *
     * @param  string  $nodeId
     * @return void
     */
    public function removeCollection($nodeId)
    {
        $this->emit('removeCollection', $nodeId);
    }

    public function render(): View
    {
        return $this->view('admin.catalog.category.category-tree');
    }
}
