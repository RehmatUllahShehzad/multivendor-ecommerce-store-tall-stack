<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Page;
use App\View\Components\Admin\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class PageAbstract extends Component
{
    use Notifies, WithFileUploads;

    public Page $page;

    public TemporaryUploadedFile|string|null $image = null;

    public $images = [];

    public function rules()
    {
        return [
            'page.title' => 'required|max:190|unique:pages,title'.($this->page->exists ? ",{$this->page->id},id" : ''),
            'page.slug' => 'required|max:80|unique:pages,slug'.($this->page->exists ? ",{$this->page->id},id" : ''),
            'page.short_description' => 'required',
        ];
    }

    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(SubMasterLayout::class, [
                'title' => 'Pages',
                'menuName' => 'cms',
            ]);
    }
}
