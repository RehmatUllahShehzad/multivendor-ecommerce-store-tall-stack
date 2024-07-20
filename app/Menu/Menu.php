<?php

namespace App\Menu;

use Closure;
use Illuminate\Support\Collection;

class Menu
{
    private Collection $items;

    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->items = collect([]);
    }

    public static function make(string $name): self
    {
        return new self($name);
    }

    public function addItem(Closure $callback): self
    {
        $item = tap(new MenuItem(), $callback);

        $this->items->add($item);

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}
