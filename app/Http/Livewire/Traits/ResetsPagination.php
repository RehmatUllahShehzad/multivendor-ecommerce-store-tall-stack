<?php

namespace App\Http\Livewire\Traits;

trait ResetsPagination
{
    public function updated(): void
    {
        $this->resetPage();
    }
}
