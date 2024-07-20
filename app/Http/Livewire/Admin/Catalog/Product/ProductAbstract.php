<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\HasCategories;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\RegistersDynamicListeners;
use App\Models\Admin\Category;
use App\Models\Admin\DietaryRestriction;
use App\Models\Admin\Nutrition;
use App\Models\Admin\Unit;
use App\Models\Product;
use App\Rules\RichTextRequiredRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

abstract class ProductAbstract extends CatalogAbstract
{
    use WithFileUploads,
        Notifies,
        HasImages,
        HasCategories,
        RegistersDynamicListeners;

    public Product $product;

    public Collection $nutritionInputs;

    /**
     * @var array<mixed>
     */
    public array $dietaryRestrictions = [];

    /**
     * @return array<string,string>
     */
    protected function getListeners()
    {
        return array_merge(
            $this->getDynamicListeners(),
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

    /**
     * @param  string | int  $key
     */
    public function removeNutritionInput($key): void
    {
        $this->nutritionInputs->pull($key);
    }

    public function getMediaModel(): Model
    {
        return $this->product;
    }

    /**
     * Define the validation rules.
     *
     * @return array<string,mixed>
     */
    public function rules()
    {
        return [
            'images' => 'required',
            'categories' => 'bail|required',
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
            'product.available_quantity' => 'bail|required|gte:0',
            'product.unit_id' => 'bail|required',
            'product.price' => 'bail|required|gte:0',
            'product.is_published' => 'bail|nullable',
            'product.is_featured' => 'bail|nullable',
        ];
    }

    /**
     * The product model for the product we want to show.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoriesProperty()
    {
        return Category::select('id', 'name')->get();
    }

    /**
     * The product model for the product we want to show.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNutritionsProperty()
    {
        return Nutrition::select('id', 'name')->get();
    }

    /**
     * The product model for the product we want to show.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUnitsProperty()
    {
        return Unit::select('id', 'name')->get();
    }

    public function initializeDietaryRestriction($selectedDietaryRestrictions = null)
    {
        if (! $selectedDietaryRestrictions) {
            $selectedDietaryRestrictions = collect();
        }

        $this->dietaryRestrictions = DietaryRestriction::select('id', 'name')->get()
            ->map(fn ($dietaryRestriction) => [
                'id' => $dietaryRestriction->id,
                'name' => $dietaryRestriction->name,
                'selected' => $selectedDietaryRestrictions->contains($dietaryRestriction->id),
            ])
            ->toArray();
    }
}
