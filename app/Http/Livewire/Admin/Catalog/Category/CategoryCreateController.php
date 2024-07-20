<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Models\Admin\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryCreateController extends CategoryAbstract
{
    public function mount(): void
    {
        $this->category = new Category();

        /** @phpstan-ignore-next-line */
        $this->category->is_featured = false;
    }

    /**
     * @return array<mixed>
     */
    public function rules()
    {
        return [
            'category.name' => ['required', function ($attribute, $value, $fail) {
                if (
                    Category::query()
                    ->where('name', $value)
                    ->where('parent_id', $this->category->parent_id)
                    ->exists()
                ) {
                    $fail(
                        __('validation.unique')
                    );
                }
            }],
            'category.is_featured' => 'required',
            'images' => 'required',
        ];
    }

    public function render(): View
    {
        return $this->view('admin.catalog.category.category-create-controller');
    }

    /**
     * @return RedirectResponse | void
     */
    public function store()
    {
        $this->validate();

        $this->category->save();

        $this->updateImages();

        $this->notify(
            __('notifications.categories.added'),
            'admin.catalog.category.index'
        );
    }
}
