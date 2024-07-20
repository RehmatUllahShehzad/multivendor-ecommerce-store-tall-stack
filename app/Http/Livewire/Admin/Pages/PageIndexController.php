<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageIndexController extends PageAbstract
{
    public string $search = '';

    public ?bool $showTrashed = false;

    public function render()
    {
        return $this->view('admin.pages.page-index-controller', function (View $view) {
            $view->with('pages', $this->getPages());
        });
    }

    public function getPages()
    {
        $query = Page::query();

        if (strlen($this->search) > 3) {
            $query->where('title', 'LIKE', "%{$this->search}%");
        }

        if ($this->showTrashed) {
            $query->withTrashed();
        }

        return $query->latest()->paginate(10);
    }
}
