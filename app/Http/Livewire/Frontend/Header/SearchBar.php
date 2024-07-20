<?php

namespace App\Http\Livewire\Frontend\Header;

use App\Models\Product;
use Livewire\Component;

class SearchBar extends Component
{
    public $search;

    public function render()
    {
        return view('frontend.header.search-bar', [
            'products' => $this->getProducts(),
            'isSearched' => $this->isSearched(),
        ]);
    }

    public function getProducts()
    {
        if (strlen(trim($this->search)) <= 1) {
            return collect();
        }

        return Product::query()
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('slug', 'LIKE', "%{$this->search}%")
                    ->orWhere('description', 'LIKE', "%{$this->search}%");
            })
            ->published()
            ->limit(20)
            ->get();
    }

    public function isSearched()
    {
        return strlen(trim($this->search)) > 0;
    }
}
