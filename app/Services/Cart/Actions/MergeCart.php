<?php

namespace App\Services\Cart\Actions;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class MergeCart
{
    /**
     * Execute the action.
     *
     * @param  \App\Models\Cart  $target
     * @param  \App\Models\Cart  $source
     * @return \App\Models\Cart
     */
    public function execute(Cart $target, Cart $source)
    {
        if ($target->id == $source->id) {
            return $target;
        }

        DB::transaction(function () use ($target, $source) {
            $source->items->map(function ($item) use ($target) {
                return [
                    'target' => $target->items->first(function ($targetItem) use ($item) {
                        return $targetItem->product_id == $item->product_id &&
                        json_encode($targetItem->meta) == json_encode($item->meta);
                    }),
                    'source' => $item,
                ];
            })->each(function ($items) use ($target) {
                // If no target, we are creating...
                if (empty($items['target'])) {
                    $target->items()->create([
                        'product_id' => $items['source']->product_id,
                        'quantity' => $items['source']->quantity,
                        'meta' => $items['source']->meta,
                    ]);

                    return;
                }

                $newMeta = $items['target']->meta ?
                    array_merge((array) $items['target']->meta, (array) $items['source']->meta) :
                    $items['source']->meta;

                $items['target']->update([
                    'quantity' => $items['target']->quantity + $items['source']->quantity,
                    'meta' => $newMeta,
                ]);
            });

            if ($source->user_id) {
                $target->update([
                    'user_id' => $source->user_id,
                ]);
            }

            $source->update([
                'merged_id' => $target->id,
            ]);
        });

        return $target;
    }
}
