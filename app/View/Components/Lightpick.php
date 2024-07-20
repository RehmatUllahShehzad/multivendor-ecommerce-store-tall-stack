<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Lightpick extends Component
{
    public string $option = '';

    public function __construct(string $option = 'false')
    {
        $this->option = $option;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lightpick');
    }
}
