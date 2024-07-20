<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class GoogleAddressAutocomplete extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return function (array $data) {
            $data['model'] = $data['attributes']->get('wire:model');
            $data['modelDefer'] = $data['attributes']->get('wire:model.defer');

            return view('components.frontend.google-address-autocomplete', $data);
        };

    }
}
