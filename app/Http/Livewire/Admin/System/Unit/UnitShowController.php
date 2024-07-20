<?php

namespace App\Http\Livewire\Admin\System\Unit;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Http\Livewire\Traits\Notifies;
use Illuminate\Contracts\View\View;

class UnitShowController extends UnitAbstract
{
    use CanDeleteRecord;
    use Notifies;

    public function render(): View
    {
        return $this->view('admin.system.unit.unit-show-controller');
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'unit.name' => 'required|string|max:30|unique:'.get_class($this->unit).',name,'.$this->unit->id,
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->unit->save();

        $this->notify(trans('notifications.unit.updated'));
    }

    public function delete(): void
    {
        $this->unit->delete();

        $this->notify(trans('notifications.unit.deleted'), 'admin.system.unit.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->unit->name;
    }
}
