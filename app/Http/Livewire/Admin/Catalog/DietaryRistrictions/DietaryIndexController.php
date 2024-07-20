<?php

namespace App\Http\Livewire\Admin\Catalog\DietaryRistrictions;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Admin\DietaryRestriction;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class DietaryIndexController extends DietaryAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $showTrashed = '';

    public string $search = '';

    public function render(): View
    {
        return $this->view('.admin.catalog.dietary-ristrictions.dietary-index-controller', function (View $view) {
            $view->with('dietaryRistrictions', $this->getDietaryRistrictions());
        });
    }

    public function getDietaryRistrictions(): Paginator
    {
        $query = DietaryRestriction::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query->paginate(10);
    }
}
