<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageManager extends Component
{
    /**
     * @var array<mixed>
     */
    public array $images;

    public string $wireModel;

    /**
     * @var array<string>
     */
    public array $filetypes;

    public bool $multiple;

    public int $maxFileSize;

    /**
     * Sepcify max Number of files
     */
    public int $maxFiles;

    /**
     * @param  int  $maxFileSize in MB
     * @param  array<mixed>  $existing
     * @param  array<mixed>  $filetypes
     */
    public function __construct(
        $existing,
        string $model,
        array $filetypes = ['image/*'],
        bool $multiple = true,
        int $maxFileSize = null,
        int $maxFiles = 10
    ) {
        $this->images = $existing;

        $this->wireModel = $model;

        $this->filetypes = $filetypes;

        $this->multiple = $multiple;

        $this->maxFiles = $maxFiles;

        $this->maxFileSize = get_max_fileupload_size($maxFileSize * 1024) / 1024;
    }

    public function render()
    {
        return view('components.image-manager');
    }
}
