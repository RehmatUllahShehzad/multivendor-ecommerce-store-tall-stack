<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public string $heading;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $heading)
    {
        $this->heading = $heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.card');
    }
}
