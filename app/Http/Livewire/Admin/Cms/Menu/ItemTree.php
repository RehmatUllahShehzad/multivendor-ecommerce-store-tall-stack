<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\MapMenuItems;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Contracts\View\View;

class ItemTree extends CmsAbstract
{
    use Notifies;
    use MapMenuItems;

    public Menu $menu;

    /**
     * The nodes for the tree.
     *
     * @var array<mixed>
     */
    public array $nodes = [];

    /**
     * The sort group.
     *
     * @var string
     */
    public $sortGroup;

    /**
     * The parent item.
     *
     * @var int|null
     */
    public $parent = null;

    public function mount(): void
    {
        $this->sortGroup = $this->parent ? "children_{$this->parent}" : 'root';

        $this->loadNodes();
    }

    protected function getListeners()
    {
        return [
            "reloadNodes{$this->parent}" => 'reloadNodes',
        ];
    }

    /**
     * Load the tree nodes.
     *
     * @return void
     */
    public function loadNodes()
    {
        $this->nodes = $this->mapMenuItems(
            $this
                ->menu
                ->items()
                ->whereParentId($parent ?? $this->parent)
                ->withCount('children')
                ->defaultOrder()
                ->get()
        );
    }

    public function reloadNodes($reloadParent = false)
    {
        $visibleChilds = collect($this->nodes)->pluck('children_visible', 'id');

        $this->loadNodes();

        if($this->parent && $reloadParent) {
            $parent_id = MenuItem::query()->whereId($this->parent)->value('parent_id');
            $this->emit("reloadNodes{$parent_id}");
        }

        $this->nodes = collect($this->nodes)
            ->map(function ($node) use ($visibleChilds) {

                $node['children_visible'] = $visibleChilds->get($node['id'], false);

                return $node;
            })
            ->toArray();

    }

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

        $this->nodes[$index]['children_visible'] = ! $this->nodes[$index]['children_visible'];
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

        $models = MenuItem::query()
            ->withCount('children')
            ->findMany($ids)
            ->sortBy(fn ($model) => $objectIdPositions[$model->getKey()])
            ->values()
            ->each(fn ($item, $index) => $item->setOrder($index));

        $this->nodes = $this->mapMenuItems($models);

        $this->notify(
            __('notifications.menu.builder.reordered')
        );
    }

    public function render(): View
    {
        return $this->view('admin.cms.menu.item-tree');
    }
}
