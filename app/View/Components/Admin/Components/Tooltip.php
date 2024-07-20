<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Tooltip extends Component
{
    public string $text = '';

    public function __construct(string $text = '')
    {
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.tooltip');
    }
}
