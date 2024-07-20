<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\CanDeleteRecord;

class PageShowController extends PageAbstract
{
    use CanDeleteRecord;

    public function render()
    {
        return $this->view('admin.pages.page-show-controller');
    }

    public function store()
    {
        $this->validate();

        $this->page->save();

        $this->notify(trans('catalog.page.updated'), 'admin.pages.index');
    }

    public function getCanDeleteConfirmationField(): string
    {
        return $this->page->slug;
    }

    public function delete(): void
    {
        $this->page->delete();

        $this->notify(trans('catalog.page.deleted'), 'admin.pages.index');
    }
}
