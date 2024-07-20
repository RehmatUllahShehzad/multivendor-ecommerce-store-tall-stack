<?php

namespace App\Http\Livewire\Admin\Catalog\Nutrition;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Nutrition;
use Illuminate\Contracts\View\View;

class NutritionCreateController extends NutritionAbstract
{
    use Notifies;

    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->nutrition = new Nutrition();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'nutrition.name' => 'required|string|max:30|unique:'.get_class($this->nutrition).',name',
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->nutrition->save();

        $this->notify(trans('notifications.nutrition.created'), 'admin.catalog.nutrition.index');
    }

    public function render(): View
    {
        return $this->view('admin.catalog.nutrition.nutrition-create-controller');
    }
}
