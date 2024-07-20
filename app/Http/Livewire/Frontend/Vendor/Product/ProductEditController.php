<?php

namespace App\Http\Livewire\Frontend\Vendor\Product;

use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductEditController extends ProductAbstract
{
    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        if (! $this->product->isOwnedBy(Auth::user())) {
            abort(403, trans('vendor.unauthorized'));
        }

        $this->selectedCategories = $this->product->categories()->pluck('id')->toArray();
        $this->selectedDietaryRestrictions = $this->product->dietaryRestrictions()->pluck('dietary_restriction_id')->toArray();
        $this->fill([
            'nutritionInputs' => $this->productNutritions(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function update(ProductService $productService)
    {
        $this->validate();

        try {
            $productService->withModel($this->product)
                ->forUser(Auth::user())
                ->withNutrition(nutritions: $this->nutritionInputs)
                ->withCategory(categories: $this->selectedCategories)
                ->withDietaryRestriction($this->selectedDietaryRestrictions)
                ->withImage(images: $this->images)
                ->save();

            session()->flash('alert-success', trans('notifications.product.updated'));

            return to_route('vendor.product.index');
        } catch (\Throwable $th) {
            $this->emit('alert-danger', $th->getMessage());
        }
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.product.product-edit-controller');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function productNutritions()
    {
        return $this->product->nutritions->map(fn ($nutrition) => [
            'nutrition_id' => $nutrition->pivot->nutrition_id, /** @phpstan-ignore-line */
            'unit_id' => $nutrition->pivot->unit_id, /** @phpstan-ignore-line */
            'value' => $nutrition->pivot->value, /** @phpstan-ignore-line */
        ]);
    }
}
