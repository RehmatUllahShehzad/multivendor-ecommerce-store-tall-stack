<?php

namespace App\View\Components\Frontend\Layouts;

use Illuminate\View\Component;

class CheckoutLayout extends Component
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
    public $description;

    /**
     * The page title.
     *
     * @var string
     */
    public $keywords;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $description, string $keywords = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('frontend.layouts.checkout-layout');
    }
}
