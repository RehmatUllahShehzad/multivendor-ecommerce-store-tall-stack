<?php

namespace App\Http\Livewire\Admin\Catalog\Nutrition;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Admin\Nutrition;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class NutritionIndexController extends CatalogAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $showTrashed = '';

    public string $search = '';

    public function render(): View
    {
        return $this->view('admin.catalog.nutrition.nutrition-index-controller', function (View $view) {
            $view->with('nutritions', $this->getNutrition());
        });
    }

    public function getNutrition(): Paginator
    {
        $query = Nutrition::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query->paginate(10);
    }
}
