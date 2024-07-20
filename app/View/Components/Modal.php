<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public ?string $id = null;

    public ?string $maxWidth = null;

    public function __construct(string $id = null, string $maxWidth = null)
    {
        $this->id = $id;
        $this->maxWidth = $maxWidth;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
