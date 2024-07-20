<?php

namespace App\Http\Livewire\Frontend\Vendor\Product;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProductCreateController extends ProductAbstract
{
    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->fill([
            'nutritionInputs' => collect([[
                'nutrition_id' => '',
                'unit_id' => '',
                'value' => '',
            ]]),
        ]);

        $this->product = new Product();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function submit(ProductService $productService)
    {
        $this->validate();

        try {
            $productService->makeFrom($this->product)
                ->forUser(Auth::user())
                ->withNutrition($this->nutritionInputs)
                ->withCategory($this->selectedCategories)
                ->withDietaryRestriction($this->selectedDietaryRestrictions)
                ->withImage($this->images)
                ->save();

            session()->flash('alert-success', trans('notifications.product.created'));

            return to_route('vendor.product.index');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.product.product-create-controller');
    }
}
