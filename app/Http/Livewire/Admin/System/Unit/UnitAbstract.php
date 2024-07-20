<?php

namespace App\Http\Livewire\Admin\System\Unit;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Unit;

abstract class UnitAbstract extends SystemAbstract
{
    use Notifies;

    public Unit $unit;
}
