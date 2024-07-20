<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Admin\Category;
use Livewire\WithFileUploads;

class CategoryAbstract extends CatalogAbstract
{
    use WithFileUploads,
        Notifies;
    use HasImages;

    public Category $category;

    /**
     * @return array<mixed>
     */
    protected function getListeners()
    {
        return array_merge(
            [],
            $this->getHasImagesListeners()
        );
    }

    public function getMediaModel(): Category
    {
        return $this->category;
    }
}
