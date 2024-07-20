<?php

namespace App\Http\Livewire\Frontend\Vendor;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Admin\Category;
use App\Models\Product;
use App\Models\Vendor;
use App\View\Components\Frontend\Layouts\GuestLayout;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ProfileShowController extends Component
{
    use WithPagination,
        ResetsPagination;

    public Vendor $vendor;

    public string $search = '';

    public string $categoryId = '';

    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function getCategoriesProperty(): Collection
    {
        return Category::latest()->get(['id', 'name']);
    }

    public function getProducts()
    {
        $products = Product::query()
            ->with([
                'thumbnail',
                'user.vendor',
            ])
            ->withAvgRating()
            ->where('user_id', $this->vendor->id)
            ->when($this->search, fn ($query) => $query->search($this->search))
            ->when(! empty($this->dateRange), fn ($query) => $query->dateFilter($this->dateRange));

            if (! empty($this->categoryId)) {
                $products->whereHas('categories', function ($query) {
                    $query->whereId($this->categoryId);
                });
            }

        return $products
            ->latest('id')
            ->published()
            ->paginate(10);
    }

    public function resetFields(): void
    {
        $this->search = '';
    }

    public function render()
    {
        return view('frontend.vendor.profile-show-controller')
            ->with('products', $this->getProducts())
            ->layout(GuestLayout::class);
    }
}
