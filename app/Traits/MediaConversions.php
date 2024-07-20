<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read ?Media $thumbnail
 */
trait MediaConversions
{
    public function getThumbnailUrl(): string | null
    {
        return $this->thumbnail?->getAvailableFullUrl(['medium']);
    }

    /**
     * Relationship for thumbnail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function thumbnail(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model')
            ->where('custom_properties->primary', true);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $transforms = config('media.transformations');

        /** @phpstan-ignore-next-line */
        collect($transforms)->each(function ($transform, $handle) {
            $conversion = $this->addMediaConversion($handle)
                ->fit(
                    $transform['fit'] ?? Manipulations::FIT_CONTAIN,
                    $transform['width'],
                    $transform['height']
                );

            if ($collections = ($transform['collections'] ?? null)) {
                /** @phpstan-ignore-next-line */
                $conversion->collections($collections);
            }

            if ($border = ($transform['border'] ?? null)) {
                $conversion->border(
                    $border['size'],
                    $border['color'],
                    $border['type']
                );
            }

            /** @phpstan-ignore-next-line */
            $conversion->keepOriginalImageFormat();
        });
    }
}
