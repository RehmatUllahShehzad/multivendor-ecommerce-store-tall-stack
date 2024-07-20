<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Models\Admin\Category;
use App\Models\Admin\DietaryRestriction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductFilterController extends Component
{
    public function render(): View
    {
        return view('frontend.products.product-filter-controller', [
            'categories' => $this->getCategories(),
            'dietaryRestrictions' => $this->getDietaryRestrictions(),
        ]);
    }

    public function getCategories(): Collection
    {
        return Category::has('products')->orderBy('name', 'asc')->get();
    }

    public function getDietaryRestrictions(): Collection
    {
        return DietaryRestriction::has('products')->orderBy('name', 'asc')->get();
    }
}
