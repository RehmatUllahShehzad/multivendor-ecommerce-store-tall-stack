<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class IconLoader
{
    /**
     * @return string|void
     */
    public static function icon(string $icon, string $attrs = null, string $style = 'outline')
    {
        if ($attrs) {
            $attrs = " class=\"{$attrs}\"";
        }

        if (Str::startsWith($icon, '<svg')) {
            return str_replace('<svg', sprintf('<svg%s', $attrs), $icon);
        }

        $iconPath = resource_path("icons/{$style}/$icon.svg");

        if (! File::exists($iconPath)) {
            return;
        }

        return str_replace('<svg', sprintf('<svg%s', $attrs), File::get($iconPath));
    }

    public static function paymentIcons(): string
    {
        return File::get(
            resource_path('icons/payment_icons.svg')
        );
    }
}
