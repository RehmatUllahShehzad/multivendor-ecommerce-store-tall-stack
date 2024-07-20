<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class SettingFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor()
    {
        return 'setting';
    }
}
