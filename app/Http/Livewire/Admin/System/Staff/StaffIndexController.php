<?php

namespace App\Http\Livewire\Admin\System\Staff;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Admin\Staff;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class StaffIndexController extends SystemAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $search = '';

    public string $showTrashed = '';

    public function render(): View
    {
        return $this->view('admin.system.staff.staff-index-controller', function (View $view) {
            $view->with('staff', $this->getStaff());
        });
    }

    public function getStaff(): Paginator
    {
        $query = Staff::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query->paginate(10);
    }
}
