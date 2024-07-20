<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Admin\CMS\CmsAbstract;
use App\Http\Livewire\Traits\MapMenuItems;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\View\View;
use Livewire\TemporaryUploadedFile;

class MenuBuilderController extends CmsAbstract
{
    use MapMenuItems;

    public Menu $menu;

    public ?MenuItem $parentItem = null;

    public ?MenuItem $item = null;

    public TemporaryUploadedFile|string|null $thumbnail = null;

    /**
     * @var array
     */
    protected $listeners = ['editMenuItem', 'removeMenuItem', 'newMenuItem'];

    /**
     * @var array<mixed>
     */
    public array $tree = [];

    protected array $rules = [
        'item.title' => 'bail|required|max:191',
        'item.link' => 'bail|required|starts_with:/,http,https|max:191',
    ];

    public function mount(): void
    {
        $this->resetFields();
    }

    public function resetFields(): void
    {
        $this->item = null;
        $this->parentItem = null;
        $this->thumbnail = null;
    }

    public function save(): void
    {
        $this->validate();

        if(! is_string($this->thumbnail)) {
            $this->item->clearMediaCollection('thumbnail');
        }

        if ($this->thumbnail instanceof TemporaryUploadedFile) {
            $this->item->addMedia($this->thumbnail->getRealPath())
                ->usingName($this->thumbnail->getClientOriginalName())
                ->toMediaCollection('thumbnail');
        }

        if ($this->parentItem) {
            $this->item->parent_id = $this->parentItem->id;
        }

        $this->item->menu_id = $this->menu->id;
        $this->item->save();

        $parent_id = $this->item->wasRecentlyCreated ? ($this->parentItem->parent_id ?? null) : $this->item->parent_id;

        $this->emit("reloadNodes{$parent_id}", $this->item->wasRecentlyCreated);

        $this->resetFields();

        $this->notify(
            __('notifications.menu.builder.saved')
        );
    }

    public function newMenuItem(MenuItem $parent = null)
    {
        $this->resetErrorBag();
        $this->item = new MenuItem();
        $this->dispatchBrowserEvent('close-menu-popup');
        $this->parentItem = $parent;
    }

    public function editMenuItem(MenuItem $item): void
    {
        $this->thumbnail = $item->getThumbnailUrl(null);
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-menu-popup');
        $this->item = $item;
    }

    public function getThumbnailPreviewProperty(): string|null
    {
        if (! $this->thumbnail) {
            return null;
        }

        if ($this->thumbnail instanceof TemporaryUploadedFile) {
            return $this->thumbnail->temporaryUrl();
        }

        return $this->thumbnail;
    }

    public function removeThumbnail(): void
    {
        if ($this->thumbnail instanceof TemporaryUploadedFile) {
            $this->thumbnail->delete();
        }

        $this->thumbnail = null;
    }

    public function removeMenuItem(MenuItem $item): void
    {
        $this->resetErrorBag();

        $item->delete();

        $this->emit("reloadNodes{$item->parent_id}", true);

        $this->resetFields();

        $this->notify(
            __('notifications.menu.builder.removed')
        );
    }

    public function render(): View
    {
        return $this
            ->view('admin.cms.menu.menu-builder-controller');
    }
}
