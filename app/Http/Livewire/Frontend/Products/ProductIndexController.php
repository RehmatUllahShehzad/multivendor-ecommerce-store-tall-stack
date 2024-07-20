<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Product;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndexController extends Component
{
    use WithPagination;
    use ResetsPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $search = '';

    public array $location = [];

    /**
     * @var array<mixed>
     */
    public array $categoryId = [];

    /**
     * @var array<mixed>
     */
    public array $dietaryRestrictionId = [];

    /**
     * @var array<mixed>
     */
    protected $queryString = [
        'search',
        'categoryId',
        'dietaryRestrictionId',
    ];

    public function mount()
    {
        if ($location = request('location')) {
            Cookie::queue('saved_location_lat', $location['lat'] ?? null);
            Cookie::queue('saved_location_lng', $location['lng'] ?? null);
        }

        $this->location = getSavedLocation();
    }

    public function render(): View
    {
        return view('frontend.products.product-index-controller', ['products' => $this->getProducts()])
            ->layout(
                MasterLayout::class,
                [
                    'title' => trans('product.product-listing'),
                    'description' => trans('product.product-listing'),
                ]
            );
    }

    public function getProducts(): Paginator
    {
        $products = Product::query()
            ->with([
                'thumbnail',
                'user.vendor',
            ])
            ->withAvgRating()
            ->published();

        if (isset($this->search) && $this->search != '') {
            $products->where(function ($query) {
                $query->where('title', 'LIKE', "%{$this->search}%");
                $query->orWhere('description', 'LIKE', "%{$this->search}%");
                $query->orWhere('attributes', 'LIKE', "%{$this->search}%");
                $query->orWhere('ingredients', 'LIKE', "%{$this->search}%");
            });
        }

        if (!empty($this->categoryId)) {
            $products->whereHas('categories', function ($query) {
                $query->whereIn('id', $this->categoryId);
            });
        }
        if (!empty($this->dietaryRestrictionId)) {
            $products->whereHas('dietaryRestrictions', function ($query) {
                $query->whereIn('dietary_restriction_id', $this->dietaryRestrictionId);
            });
        }
        if (!empty($this->location['lat']) && !empty($this->location['lng'])) {
            $products->nearTo($this->location['lat'], $this->location['lng']);
        } else {
            $products->isVendorPickup();
        }

        return $products->paginate(12);
    }

    public function resetFields(): void
    {
        $this->search = '';
    }
}
