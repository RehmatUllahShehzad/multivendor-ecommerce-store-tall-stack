<?php

namespace App\Http\Livewire\Admin\System\Setting;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\Notifies;
use Livewire\WithFileUploads;

abstract class SettingAbstract extends SystemAbstract
{
    use Notifies, WithFileUploads;
}
