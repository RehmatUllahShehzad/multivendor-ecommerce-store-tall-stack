<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Str;

trait RegistersDynamicListeners
{
    /**
     * @return array<string,string>
     */
    public function getDynamicListeners()
    {
        $listeners = [];
        foreach (get_class_methods(get_called_class()) as $methodName) {
            if (! Str::startsWith($methodName, 'register') || ! Str::endsWith($methodName, 'Listeners')) {
                continue;
            }

            $listeners = array_merge($listeners, $this->{$methodName}());
        }

        return $listeners;
    }
}
