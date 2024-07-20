<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Slideover extends Component
{
    public string $title = '';

    public bool $nested = false;

    public bool $form = true;

    public function __construct(string $title = '', bool $nested = false, bool $form = false)
    {
        $this->title = $title;
        $this->nested = $nested;
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.slideover');
    }
}
