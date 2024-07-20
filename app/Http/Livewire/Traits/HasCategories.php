<?php

namespace App\Http\Livewire\Traits;

use App\Models\Admin\Category;
use Illuminate\Support\Collection;

trait HasCategories
{
    /**
     * The associated product collections.
     *
     * @var collection
     */
    public Collection $categories;

    /**
     * @return array<string,string>
     */
    public function registerHasCategoryListeners()
    {
        return [
            'categorySelected' => 'updateCategories',
        ];
    }

    /**
     * Mount the component trait.
     *
     * @return void
     */
    public function mountHasCategories()
    {
        $this->categories = $this->product->categories->map(function ($category) {
            return [
                'id' => $category->id,
                'group_id' => $category->collection_group_id, /** @phpstan-ignore-line */
                'name' => $category->name,
                'thumbnail' => optional($category->thumbnail)->getUrl(),
            ];
        });
    }

    /**
     * @param  array<int>  $categoryIds
     */
    public function updateCategories(array $categoryIds): void
    {
        $selectedCategories = Category::findMany($categoryIds)->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'thumbnail' => optional($category->thumbnail)->getUrl(),
            ];
        });

        $this->categories = $this->categories->count() ?
            $this->categories->merge($selectedCategories) :
            $selectedCategories;
    }

    /**
     * Remove the collection by it's index.
     *
     * @param  int|string  $index
     * @return void
     */
    public function removeCollection($index)
    {
        $this->categories->forget($index);
        $this->emit('removed-existing-category', $index);
    }
}
