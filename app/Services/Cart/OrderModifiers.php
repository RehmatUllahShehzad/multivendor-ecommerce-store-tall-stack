<?php

namespace App\Services\Cart;

use Illuminate\Support\Collection;

class OrderModifiers
{
    protected Collection $modifiers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modifiers = collect();
    }

    public function getModifiers(): Collection
    {
        return $this->modifiers;
    }

    public function add($modifier): self
    {
        $this->modifiers->push($modifier);

        return $this;
    }
}
