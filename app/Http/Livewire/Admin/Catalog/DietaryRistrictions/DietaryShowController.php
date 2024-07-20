<?php

namespace App\Http\Livewire\Admin\Catalog\DietaryRistrictions;

use App\Http\Livewire\Traits\CanDeleteRecord;
use Illuminate\Contracts\View\View;

class DietaryShowController extends DietaryAbstract
{
    use CanDeleteRecord;

    public function render(): View
    {
        return $this->view('.admin.catalog.dietary-ristrictions.dietary-show-controller');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'dietaryRistriction.name' => 'required|string|max:30|unique:'.get_class($this->dietaryRistriction).',name,'.$this->dietaryRistriction->id,
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->dietaryRistriction->save();

        $this->notify(trans('notifications.dietary-ristriction.updated'));
    }

    public function delete(): void
    {
        $this->dietaryRistriction->delete();

        $this->notify(trans('notifications.dietary-ristriction.deleted'), 'admin.catalog.dietary.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->dietaryRistriction->name;
    }
}
