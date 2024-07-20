<?php

return [
    'styles' => [],
    'scripts' => [],

    'assets' => [
        'upload-url' => null,
        'disk' => env('FILESYSTEM_DISK', 'local'),
        'path' => 'public/editor',
        'filemanager_url' => '/file-manager/',
        'editor_icons' => asset('/vendor/laravel-editor/svg'),
        'proxy_url' => null,
        'proxy_url_input' => 'file',
    ],
];
