<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * The value to display on the dropdown button.
     *
     * @var string
     */
    public string $value;

    public string $position = 'left';

    /**
     * Whether we should be displaying a minimal "three dot" dropdown.
     *
     * @var bool
     */
    public bool $minimal = false;

    public function __construct(string $value = null, bool $minimal = false, string $position = 'left')
    {
        $this->value = $value;
        $this->minimal = $minimal;
        $this->position = $position;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.drop-down');
    }
}
