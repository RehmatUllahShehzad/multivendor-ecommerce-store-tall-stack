<?php

namespace App\Http\Livewire\Admin\Catalog\DietaryRistrictions;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\DietaryRestriction;

class DietaryAbstract extends CatalogAbstract
{
    use Notifies;

    public DietaryRestriction $dietaryRistriction;
}
