<?php

namespace App\View\Components\Admin\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.table.index');
    }
}
