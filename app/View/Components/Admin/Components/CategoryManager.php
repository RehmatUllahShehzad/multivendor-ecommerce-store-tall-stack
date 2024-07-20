<?php

namespace App\View\Components\Admin\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryManager extends Component
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public $categories;

    /**
     * @param  \Illuminate\Support\Collection  $existing
     */
    public function __construct($existing)
    {
        $this->categories = $existing;
    }

    public function render(): View
    {
        return view('admin.components.category-manager');
    }
}
