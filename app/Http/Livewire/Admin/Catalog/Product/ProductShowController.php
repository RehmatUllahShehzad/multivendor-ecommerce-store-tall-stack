<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Services\ProductService;
use Illuminate\Contracts\View\View;

class ProductShowController extends ProductAbstract
{
    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->fill([
            'nutritionInputs' => $this->productNutritions(),
        ]);

        $this->initializeDietaryRestriction($this->product->dietaryRestrictions()->pluck('dietary_restriction_id'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function update(ProductService $productService)
    {
        $this->validate();
        try {
            $productService->withModel($this->product)
                ->forUser($this->product->user)
                ->withNutrition($this->nutritionInputs)
                ->withCategory($this->categories->pluck('id')->toArray())
                ->withDietaryRestriction(collect($this->dietaryRestrictions)->where('selected', true)->pluck('id')->toArray())
                ->withImage($this->images)
                ->save();

            $this->notify(
                __('notifications.product.updated'),
                'admin.catalog.product.index'
            );
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }

    public function render(): View
    {
        return $this->view('admin.catalog.product.product-show-controller');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function productNutritions()
    {
        return $this->product->nutritions->map(fn ($nutrition) => [
            'nutrition_id' => $nutrition->pivot->nutrition_id,
            /** @phpstan-ignore-line */
            'unit_id' => $nutrition->pivot->unit_id,
            /** @phpstan-ignore-line */
            'value' => $nutrition->pivot->value,
        /** @phpstan-ignore-line */
        ]);
    }

    public function delete(): void
    {
        $this->product->delete();

        $this->notify(trans('notifications.product.deleted'), 'admin.catalog.product.index');
    }
}
