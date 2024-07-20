<?php

namespace App\View\Components\Admin\Components\Input;

use Illuminate\View\Component;

class Price extends Component
{
    /**
     * Whether or not the input has an error to show.
     *
     * @var bool
     */
    public bool $error = false;

    public string $symbol;

    public string $currencyCode;

    /**
     * Initialise the component.
     *
     * @param  string  $symbol
     * @param  string  $currencyCode
     * @param  bool  $error
     */
    public function __construct($symbol, $currencyCode, $error = false)
    {
        $this->symbol = $symbol;
        $this->currencyCode = $currencyCode;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.price');
    }
}
