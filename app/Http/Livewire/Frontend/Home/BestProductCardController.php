<?php

namespace App\Http\Livewire\Frontend\Home;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class BestProductCardController extends Component
{
    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->product->loadAvgRating();
    }

    public function render(): View
    {
        return view('frontend.home.best-product-card');
    }
}
