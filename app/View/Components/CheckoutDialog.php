<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckoutDialog extends Component
{
    public string $form = '';

    public string $title = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $form = '', string $title = '')
    {
        $this->form = $form;
        $this->title = $title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkout-dialog');
    }
}
