<?php

namespace App\View\Components\Admin\Components\Dropdown;

use Illuminate\View\Component;

class Index extends Component
{
    /**
     * The value to display on the dropdown button.
     *
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $position = 'left';

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
        return view('admin.components.dropdown.index');
    }
}
