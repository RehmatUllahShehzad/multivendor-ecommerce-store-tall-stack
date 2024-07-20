<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Dialog extends Component
{
    public ?string $id = null;

    public ?string $maxWidth = null;

    public ?string $form = null;

    public function __construct(string $id = null, string $maxWidth = null, string $form = null)
    {
        $this->id = $id;
        $this->maxWidth = $maxWidth;
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.dialog');
    }
}
