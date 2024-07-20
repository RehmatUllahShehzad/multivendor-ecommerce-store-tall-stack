<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Livewire\TemporaryUploadedFile;
use Spatie\Activitylog\Facades\LogBatch;

trait WithSaveImages
{
    /**
     * Abstract method to get the media model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract protected function getMediaModel();

    public function updateImages(): void
    {
        DB::transaction(function () {
            LogBatch::startBatch();

            $owner = $this->getMediaModel();

            // Need to find any images that have been deleted.
            // We need to also get a fresh instance of the relationship
            // as we may have changes that Livewire/Eloquent might not be aware of.
            $imageIds = collect($this->images)->pluck('id')->toArray();

            /** @phpstan-ignore-next-line */
            $owner->refresh()->media->reject(function ($media) use ($imageIds) {
                /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
                return in_array($media->id, $imageIds);
            })->each(function ($media) {
                $media->forceDelete();
            });

            foreach ($this->images as $key => $image) {
                if (empty($image['id'])) {
                    $file = TemporaryUploadedFile::createFromLivewire(
                        $image['filename']
                    );

                    /** @phpstan-ignore-next-line */
                    $media = $owner->addMedia($file->getRealPath())
                        ->toMediaCollection(
                            get_class($owner)
                        );

                    activity()
                        ->performedOn($owner)
                        ->withProperties(['media' => $media->toArray()])
                        ->event('added_image')
                        ->useLog('marketplace')
                        ->log('added_image');

                    // Add ID for future and processing now.
                    $this->images[$key]['id'] = $media->id;
                    $image['id'] = $media->id;
                }

                $media = app(config('media-library.media_model'))::find($image['id']);

                $media->setCustomProperty('caption', $image['caption']);
                $media->setCustomProperty('primary', $image['primary']);
                $media->setCustomProperty('position', $image['position']);
                $media->save();
            }

            LogBatch::endBatch();
        });
    }
}
