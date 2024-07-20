<?php

namespace App\View\Components\Admin\Layouts;

use Illuminate\View\Component;

class MasterLayout extends Component
{
    /**
     * The page title.
     *
     * @var string
     */
    public $title;

    /**
     * The page title.
     *
     * @var string
     */
    public $pageContainerClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $pageContainerClasses = null)
    {
        $this->title = $title;

        $this->pageContainerClasses = $pageContainerClasses ?? 'overflow-hidden';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.layouts.master-layout');
    }
}
