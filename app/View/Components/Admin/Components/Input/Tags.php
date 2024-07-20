<?php

namespace App\View\Components\Admin\Components\Input;

use Illuminate\View\Component;

class Tags extends Component
{
    /**
     * Whether or not the input has an error to show.
     *
     * @var bool
     */
    public bool $error = false;

    /**
     * @var array<string>
     */
    public array $tags = [];

    /**
     * Initialise the component.
     *
     * @param  bool  $error
     * @param  array<string>  $tags
     */
    public function __construct($error = false, $tags = [])
    {
        $this->error = $error;
        $this->tags = $tags;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.tags');
    }
}
