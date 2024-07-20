<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Models\Page;

class PageCreateController extends PageAbstract
{
    public function mount()
    {
        $this->page = new Page();
    }

    public function store()
    {
        $this->validate();

        $this->page->save();

        $this->notify(trans('catalog.page.created'), 'admin.pages.index');
    }

    public function render()
    {
        return $this->view('admin.pages.page-create-controller');
    }
}
