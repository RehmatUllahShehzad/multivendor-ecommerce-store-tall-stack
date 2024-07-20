<?php

namespace App\Http\Livewire\Admin\Catalog\Nutrition;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Http\Livewire\Traits\Notifies;
use Illuminate\Contracts\View\View;

class NutritionShowController extends NutritionAbstract
{
    use CanDeleteRecord;
    use Notifies;

    public function render(): View
    {
        return $this->view('admin.catalog.nutrition.nutrition-show-controller');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'nutrition.name' => 'required|string|max:30|unique:'.get_class($this->nutrition).',name,'.$this->nutrition->id,
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->nutrition->save();

        $this->notify(trans('notifications.nutrition.updated'));
    }

    public function delete(): void
    {
        $this->nutrition->delete();

        $this->notify(trans('notifications.nutrition.deleted'), 'admin.catalog.nutrition.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->nutrition->name;
    }
}
