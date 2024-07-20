<?php

namespace App\View\Components\Admin\Components\Input;

use Illuminate\View\Component;

class Toggle extends Component
{
    /**
     * Whether the toggle should be in an on state.
     *
     * @var bool
     */
    public $on = false;

    /**
     * Whether the toggle should be disabled.
     *
     * @var bool
     */
    public $disabled = false;

    /**
     * The Off value.
     *
     * @var bool
     */
    public $offValue = false;

    /**
     * The on value.
     *
     * @var int
     */
    public $onValue = 1;

    /**
     * The id of component.
     *
     * @var string
     */
    public $id;

    /**
     * Create the component instance.
     *
     * @param  string  $id
     * @param  bool  $on
     * @param  int  $onValue
     * @param  bool  $offValue
     * @param  bool  $disabled
     */
    public function __construct($on = false, $disabled = false, $onValue = 1, $offValue = false, $id = null)
    {
        $this->on = $on;
        $this->id = $id ? $id : microtime();
        $this->disabled = $disabled;
        $this->onValue = $onValue;
        $this->offValue = $offValue;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.toggle');
    }
}
