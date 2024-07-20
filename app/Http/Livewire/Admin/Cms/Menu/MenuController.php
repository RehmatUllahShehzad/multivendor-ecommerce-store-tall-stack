<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class MenuController extends CmsAbstract
{
    public Collection $menus;

    public function mount(): void
    {
        $this->menus = Menu::get();
    }

    public function render(): View
    {
        return $this->view('admin.cms.menu.menu-controller');
    }
}
