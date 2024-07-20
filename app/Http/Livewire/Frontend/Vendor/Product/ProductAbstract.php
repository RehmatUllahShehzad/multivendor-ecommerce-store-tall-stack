<?php

namespace App\Http\Livewire\Frontend\Vendor\Product;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Category;
use App\Models\Admin\DietaryRestriction;
use App\Models\Admin\Nutrition;
use App\Models\Admin\Unit;
use App\Models\Product;
use App\Rules\RichTextRequiredRule;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

class ProductAbstract extends VendorAbstract
{
    use WithFileUploads,
        Notifies,
        HasImages;

    public Product $product;

    public Collection $nutritionInputs;

    /**
     * @var array<mixed>
     */
    public array $selectedCategories = [];

    /**
     * @var array<mixed>
     */
    public array $selectedDietaryRestrictions = [];

    /**
     * @return array<mixed>
     */
    protected function getListeners()
    {
        return array_merge(
            [],
            $this->getHasImagesListeners()
        );
    }

    public function addNutritionInput(): void
    {
        $this->nutritionInputs->push([
            'nutrition_id' => '',
            'unit_id' => '',
            'value' => '',
        ]);
    }

    public function removeNutritionInput(string $key): void
    {
        $this->nutritionInputs->pull($key);
    }

    public function getMediaModel(): Product
    {
        return $this->product;
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    public function rules()
    {
        return [
            'images' => 'required',
            'selectedCategories' => 'bail|required',
            'nutritionInputs.*.nutrition_id' => 'required',
            'nutritionInputs.*.unit_id' => 'required',
            'nutritionInputs.*.value' => 'bail|required|gte:0',
            'product.title' => 'bail|required|max:100',
            'product.description' => [
                'bail',
                'required',
                'max:1000',
                new RichTextRequiredRule(
                    min: 10,
                    max: 1000
                ),
            ],
            'product.attributes' => 'bail|nullable|max:1000',
            'product.ingredients' => 'bail|nullable|max:500',
            'product.available_quantity' => 'bail|required|integer|gte:0',
            'product.unit_id' => 'bail|required',
            'product.price' => 'bail|required|gt:0|regex:/^\d*(\.\d{2})?$/',
            'product.is_published' => 'bail|nullable',
        ];
    }

    /**
     * The product model for the product we want to show.
     *
     * @return array<mixed>
     */
    public function getCategoriesProperty()
    {
        return Category::select('id', 'name')->get()
            ->mapWithKeys(fn ($category) => [$category->id => $category->name])
            ->toArray();
    }

    /**
     * The product model for the product we want to show.
     *
     * @return array<mixed>
     */
    public function getDietaryRestrictionsProperty()
    {
        return DietaryRestriction::select('id', 'name')->get()
            ->mapWithKeys(fn ($dietaryRestriction) => [$dietaryRestriction->id => $dietaryRestriction->name])
            ->toArray();
    }

    /**
     * The product model for the product we want to show.
     */
    public function getNutritionsProperty(): Collection
    {
        return Nutrition::select('id', 'name')->get();
    }

    /**
     * The product model for the product we want to show.
     */
    public function getUnitsProperty(): Collection
    {
        return Unit::select('id', 'name')->get();
    }
}
