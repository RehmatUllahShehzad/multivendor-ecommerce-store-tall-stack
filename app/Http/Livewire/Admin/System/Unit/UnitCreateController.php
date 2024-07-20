<?php

namespace App\Http\Livewire\Admin\System\Unit;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Unit;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UnitCreateController extends UnitAbstract
{
    use Notifies;

    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->unit = new Unit();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'unit.name' => 'required|string|max:30|unique:'.get_class($this->unit).',name',
        ];
    }

    public function render(): View
    {
        return $this->view('admin.system.unit.unit-create-controller');
    }

    public function create(): void
    {
        $this->validate();

        $this->unit->save();

        $this->notify(trans('notifications.unit.created'), 'admin.system.unit.index');
    }
}
