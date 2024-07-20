<?php

namespace App\Http\Livewire\Admin\Catalog\DietaryRistrictions;

use App\Models\Admin\DietaryRestriction;
use Illuminate\Contracts\View\View;

class DietaryCreateController extends DietaryAbstract
{
    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->dietaryRistriction = new DietaryRestriction();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'dietaryRistriction.name' => 'required|string|max:30|unique:'.get_class($this->dietaryRistriction).',name',
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->dietaryRistriction->save();

        $this->notify(trans('notifications.dietary.ristriction.created'), 'admin.catalog.dietary.index');
    }

    public function render(): View
    {
        return $this->view('.admin.catalog.dietary-ristrictions.dietary-create-controller');
    }
}
