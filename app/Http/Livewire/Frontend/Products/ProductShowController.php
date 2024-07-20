<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Models\Product;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductShowController extends Component
{
    public Product $product;

    /**
     * @var array<mixed>
     */
    public array $selectedDietaryRestrictions = [];

    public function mount(): void
    {
        $this->product->addView();

        $this->product->loadAvgRating();

        $this->selectedDietaryRestrictions = $this->product->dietaryRestrictions()->pluck('name')->toArray();
    }

    public function render(): View
    {
        return view('frontend.products.product-show-controller')
            ->layout(
                MasterLayout::class,
                [
                    'title' => trans('product.product-detail'),
                    'description' => trans('product.product-detail'),
                ]
            );
    }
}
