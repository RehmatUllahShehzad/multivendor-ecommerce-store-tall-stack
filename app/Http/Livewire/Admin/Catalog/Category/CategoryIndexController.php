<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\MapCategories;
use App\Models\Admin\Category;
use Illuminate\Contracts\View\View;

class CategoryIndexController extends CatalogAbstract
{
    use MapCategories;

    /**
     * @var array<mixed>
     */
    public array $tree = [];

    public function mount(): void
    {
        $this->loadTree();
    }

    /**
     * Load the tree.
     *
     * @return void
     */
    public function loadTree()
    {
        $this->tree = $this->mapCategories(
            Category::query()->withCount('children')->root()->defaultOrder()->get()
        );
    }

    public function render(): View
    {
        return $this->view('admin.catalog.category.category-index-controller');
    }
}
