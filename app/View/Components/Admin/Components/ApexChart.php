<?php

namespace App\View\Components\Admin\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ApexChart extends Component
{
    public string $key;

    public Collection $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $key, Collection $options)
    {
        $this->key = $key;

        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.apex-chart');
    }
}
