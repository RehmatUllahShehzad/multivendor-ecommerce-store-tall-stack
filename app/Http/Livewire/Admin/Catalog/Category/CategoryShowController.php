<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Models\Admin\Category;
use Illuminate\Contracts\View\View;

class CategoryShowController extends CategoryAbstract
{
    use CanDeleteRecord;

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
                    ->where('id', '<>', $this->category->id)
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
        return $this->view('admin.catalog.category.category-show-controller');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse | void
     */
    public function update()
    {
        $this->validate();

        $this->category->save();

        $this->updateImages();

        $this->notify(
            __('notifications.categories.updated'),
            'admin.catalog.category.index'
        );
    }

    public function delete(): void
    {
        $this->category->delete();

        $this->notify(
            __('notifications.categories.deleted'),
            'admin.catalog.category.index'
        );
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->category->name;
    }
}
