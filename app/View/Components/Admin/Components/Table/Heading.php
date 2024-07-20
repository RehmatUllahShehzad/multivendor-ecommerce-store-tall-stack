<?php

namespace App\View\Components\Admin\Components\Table;

use Illuminate\View\Component;

class Heading extends Component
{
    /**
     * Whether the heading should be sortable.
     *
     * @var bool
     */
    public bool $sortable = false;

    /**
     * The direction to sort.
     *
     * @var string
     */
    public $direction;

    /**
     * Whether the heading spans multiple columns.
     *
     * @var bool
     */
    public bool $multiColumn;

    /**
     * Create the component instance.
     *
     * @param  bool  $sortable
     * @param  null|string  $direction
     * @param  bool  $multiColumn
     */
    public function __construct(bool $sortable = false, $direction = null, bool $multiColumn = false)
    {
        $this->sortable = $sortable;
        $this->direction = $direction;
        $this->multiColumn = $multiColumn;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.table.heading');
    }
}
