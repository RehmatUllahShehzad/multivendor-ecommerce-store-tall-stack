<?php

namespace App\View\Components\Admin\Layouts;

use Illuminate\View\Component;

class SubMasterLayout extends Component
{
    public string $menuName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $menuName = 'system')
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
        return view('admin.layouts.sub-master-layout');
    }
}
