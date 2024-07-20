<?php

namespace LaraEditor\App\Editor;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AssetRepository
{
    private $diskPath;

    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk(config('laraeditor.assets.disk'));
        $this->diskPath = config('laraeditor.assets.path');
    }

    public function getAllMediaLinks(): array
    {
        return collect($this->disk->allFiles($this->diskPath))
            ->map(fn ($file) => $this->disk->url($file))
            ->toArray();
    }

    public function getUploadUrl(): mixed
    {
        return config('laraveleditor.assets.upload-url', route('laraeditor.asset.store'));
    }

    public function getFileManagerUrl(): mixed
    {
        return config('laraveleditor.assets.filemanager_url', '/file-manager/');
    }

    public function addAsset(UploadedFile $file): mixed
    {
        /**
         * Check if file is submitted by Image Editor Its name will be blob
         */
        if ('blob' == $file->getClientOriginalName()) {
            $path = $this->disk->putFile($this->diskPath, $file, 'public');

            return $this->disk->url($path);
        }

        $path = $this->disk->putFileAs($this->diskPath, $file, $file->getClientOriginalName(), 'public');

        return $this->disk->url($path);
    }

    public function addAssetFromRequest($assetName = 'file'): mixed
    {
        $files = request()->file($assetName);
        if (is_array($files)) {
            $addedFiles = [];
            foreach ($files as $file) {
                $addedFiles = $this->addAsset($file);
            }

            return $addedFiles;
        }

        return [
            $this->addAsset($files),
        ];
    }
}
