<?php

namespace App\Http\Livewire\Traits;

use App\Traits\WithSaveImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasImages
{
    use WithSaveImages;

    /**
     * New images we want to upload.
     *
     * @var array<mixed>
     */
    public $imageUploadQueue = [];

    /**
     * The existing images for the model.
     *
     * @var array<mixed>
     */
    public $images = [];

    /**
     * Collection name to add media into
     *
     * @var string
     */
    public $collectionName;

    /**
     * @return array<mixed>
     */
    public function getHasImagesListeners()
    {
        return [
            'upload:finished' => 'handleUploadFinished',
        ];
    }

    /**
     * Define validation rules for images.
     *
     * @return array<mixed>
     */
    protected function hasImagesValidationRules()
    {
        return [
            'imageUploadQueue.*' => 'image|max:'.get_max_fileupload_size(2),
            'images.*.caption' => 'nullable|string',
        ];
    }

    /**
     * Mount the component trait.
     *
     * @return void
     */
    public function mountHasImages()
    {
        $owner = $this->getMediaModel();

        $this->collectionName = get_class($owner);

        /** @phpstan-ignore-next-line */
        $this->images = $owner->media->map(function ($media) {
            /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
            return [
                'id' => $media->id,
                'sort_key' => Str::random(),
                'thumbnail' => $media->getAvailableFullUrl(['small']),
                'original' => $media->getFullUrl(),
                'preview' => false,
                'caption' => $media->getCustomProperty('caption'),
                'primary' => $media->getCustomProperty('primary'),
                'position' => $media->getCustomProperty('position', 1),
            ];
        })->sortBy('position')->values()->toArray();
    }

    /**
     * Listener for when new images are uploaded.
     *
     * @return void
     */
    public function updatedImages()
    {
        $this->resetErrorBag();
        $this->validate($this->hasImagesValidationRules());
    }

    /**
     * Method to handle when Livewire uploads a product image.
     *
     * @param  string  $name
     * @param  array<mixed>  $filenames
     * @return void
     */
    public function handleUploadFinished($name, array $filenames = [])
    {
        /**
         * If the upload wasn't triggered via the drag and drop upload queue
         * then we ignore it since we don't want the files to appear in the
         * main image block.
         */
        if ($name != 'imageUploadQueue') {
            return;
        }

        if ($this->errorBag->has('imageUploadQueue.*') || $this->errorBag->has('images.*.caption')) {
            unset($this->imageUploadQueue[0]);

            return;
        }

        foreach ($filenames as $key => $filename) {
            $file = TemporaryUploadedFile::createFromLivewire($filename);

            $this->images[] = [
                'thumbnail' => $file->temporaryUrl(),
                'sort_key' => Str::random(),
                'filename' => $filename,
                'original' => $file->temporaryUrl(),
                'caption' => null,
                'position' => count($this->images) + 1,
                'preview' => false,
                'primary' => ! count($this->images),
            ];

            unset($this->imageUploadQueue[$key]);
        }
    }

    /**
     * Method to handle reordering.
     *
     * @param  array<mixed>  $sort
     * @return void
     */
    public function sort($sort): void
    {
        /** @phpstan-ignore-next-line */
        foreach ($sort['items'] as $item) {
            $index = collect($this->images)->search(fn ($image) => $item['id'] == $image['sort_key']);
            $this->images[$index]['position'] = $item['order'];
        }

        $this->images = collect($this->images)->sortBy('position')->values()->toArray();
    }

    /**
     * Set temporary collection while updating images to collection
     */
    public function updateImagesUsingCollection(): void
    {
        $oldCollectionName = $this->collectionName;

        $this->updateImages();

        $this->collectionName = $oldCollectionName;
    }

    /**
     * Sets an image to be primary and if one already exists will
     * remove it's primary state.
     *
     * @param  int|string  $imageKey
     * @return void
     */
    public function setPrimary($imageKey)
    {
        foreach ($this->images as $key => $image) {
            $this->images[$key]['primary'] = $imageKey == $key;
        }
    }

    /**
     * Method to handle firing of command to generate media conversions.
     *
     * @param  string  $id
     * @return void
     */
    public function regenerateConversions($id)
    {
        Artisan::call('media-library:regenerate --ids='.$id);
        $this->notify(
            __('global.image-manager.remake_transforms.notify.success')
        );
    }

    /**
     * Removes an image from the array using it's sort key.
     *
     * @param  string  $sortKey
     * @return void
     */
    public function removeImage($sortKey)
    {
        $index = collect($this->images)->search(fn ($image) => $sortKey == $image['sort_key']);

        if (! isset($this->images[$index])) {
            return;
        }

        $image = $this->images[$index];

        unset($this->images[$index]);

        // If this was a primary image and we have images left over
        // set the first image to be primary.
        if ($image['primary'] && count($this->images)) {
            $this->images[array_key_first($this->images)]['primary'] = true;
        }
    }
}
