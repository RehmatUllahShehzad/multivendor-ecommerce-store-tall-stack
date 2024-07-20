<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2 extends Component
{
    /**
     * @var array<int,string>
     */
    public array $options;

    /**
     * @param  array<int,string>  $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select2');
    }
}
