<?php

namespace App\View\Components\Frontend\Layouts;

use Illuminate\View\Component;

class SubMasterLayout extends Component
{
    public string $menuName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $menuName = 'customer')
    {
        $this->menuName = $menuName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('frontend.layouts.sub-master-layout');
    }
}
