<?php

namespace App\View\Components;

use App\Services\Admin\MenuService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public string $name;

    public Collection $items;

    public function __construct(string $name)
    {
        $this->name = $name;

        /** @var \App\Menu\Menu | null $menu */
        $menu = MenuService::menu($name);

        if (! $menu) {
            throw new Exception("Menu {$name} not registered. Please check name or register a menu with this name.");
        }

        $this->items = $menu->getItems();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu');
    }
}
