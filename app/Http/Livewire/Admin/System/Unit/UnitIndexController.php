<?php

namespace App\Http\Livewire\Admin\System\Unit;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Admin\Unit;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class UnitIndexController extends SystemAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $search = '';

    public string $showTrashed = '';

    public function render(): View
    {
        return $this->view('admin.system.unit.unit-index-controller', function (View $view) {
            $view->with('units', $this->getUnits());
        });
    }

    public function getUnits(): Paginator
    {
        $query = Unit::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query->paginate(10);
    }
}
