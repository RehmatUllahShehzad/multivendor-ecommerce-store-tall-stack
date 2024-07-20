<?php

namespace App\View\Components\Admin\Components\Input;

class Password extends Text
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.password');
    }
}
