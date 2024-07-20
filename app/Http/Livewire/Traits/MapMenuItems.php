<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Database\Eloquent\Collection;

trait MapMenuItems
{
    public function mapMenuItems(Collection $items): array
    {
        return $items
            ->map(fn ($item) => [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'title' => $item->title,
                'sort_order' => $item->sort_order,
                'children' => [],
                'children_count' => $item->children_count,
                'children_visible' => false,
                'thumbnail' => $item->getThumbnailUrl(),
            ])
            ->toArray();
    }
}
