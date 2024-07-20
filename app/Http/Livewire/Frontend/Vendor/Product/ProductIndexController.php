<?php

namespace App\Http\Livewire\Frontend\Vendor\Product;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ProductIndexController extends VendorAbstract
{
    use WithPagination,
        ResetsPagination;

    public string $search = '';

    public string $sortBy = 'default';

    /**
     * @var array<mixed>
     */
    protected $queryString = ['sortBy'];

    /**
     * @var array<mixed>
     */
    public array $dateRange = [];

    protected string $paginationTheme = 'bootstrap';

    public function mount(): void
    {
        $this->search = '';
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.product.product-index-controller', function (View $view) {
            $view->with('products', $this->getProducts());
        });
    }

    public function getProducts(): Paginator
    {
        $query = Product::query()
            ->ofUser(Auth::user())
            ->when($this->search, fn ($query) => $query->search($this->search))
            ->when(! empty($this->dateRange), fn ($query) => $query->dateFilter($this->dateRange));

        if ($this->sortBy == 'newest') {
            $query->latest('created_at');
        }

        if ($this->sortBy == 'date') {
            $query->orderBy('id', 'desc');
        }

        if ($this->sortBy == 'asc') {
            $query->orderBy('title', 'ASC');
        }

        if ($this->sortBy == 'desc') {
            $query->orderBy('title', 'DESC');
        }

        if ($this->sortBy == 'publish') {
            $query->where('is_published', 1);
        }

        if ($this->sortBy == 'un_publish') {
            $query->where('is_published', 0);
        }

        return $query
            ->latest('created_at')
            ->paginate(10);
    }

    public function resetFields(): void
    {
        $this->search = '';
        $this->dateRange = [];
    }
}
