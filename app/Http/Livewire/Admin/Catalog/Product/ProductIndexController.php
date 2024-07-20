<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class ProductIndexController extends CatalogAbstract
{
    use WithPagination,
        ResetsPagination;

    public string $search = '';

    public string $sortBy = 'default';

    /**
     * @var array<string>
     */
    protected $queryString = ['sortBy'];

    public function mount(): void
    {
        $this->search = '';
    }

    public function render(): View
    {
        return $this->view('admin.catalog.product.product-index-controller', function (View $view) {
            $view->with('products', $this->getProducts());
        });
    }

    public function getProducts(): Paginator
    {
        $query = Product::query()
            ->when($this->search, fn ($query) => $query->search($this->search));

        if ($this->sortBy == 'latest') {
            $query->latest('created_at');
        }

        if ($this->sortBy == 'oldest') {
            $query->oldest('created_at');
        }

        if ($this->sortBy == 'asc') {
            $query->orderBy('title', 'asc');
        }

        if ($this->sortBy == 'desc') {
            $query->orderBy('title', 'desc');
        }

        return $query
            ->orderBy('id', 'ASC')
            ->paginate(10);
    }
}
