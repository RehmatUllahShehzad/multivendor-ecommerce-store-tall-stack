<?php

namespace App\Http\Livewire\Admin\Catalog\Nutrition;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Nutrition;

abstract class NutritionAbstract extends CatalogAbstract
{
    use Notifies;

    public Nutrition $nutrition;
}
