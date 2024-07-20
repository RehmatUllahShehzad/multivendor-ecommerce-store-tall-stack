<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraEditor\App\Contracts\Editable;
use LaraEditor\App\Traits\EditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model implements Editable, HasMedia
{
    use HasFactory,
        SoftDeletes,
        HasSlug,
        EditableTrait,
        InteractsWithMedia;

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('deleted_at', '=', null);
    }

    public function getSlugOptions(): SlugOptions
    {
        $options = SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');

        if ($this->slug && strlen($this->slug) >= 0) {
            $options->preventOverwrite();
        }

        return $options;
    }

    public function isHomePage(): bool
    {
        return $this->slug == '/';
    }

    public function getEditorStoreUrl(): ?string
    {
        return route('admin.editor.store', $this);
    }

    public function getEditorLoadUrl(): ?string
    {
        return route('admin.editor.index', $this);
    }

    public function getEditorTemplatesUrl(): ?string
    {
        return route('admin.editor.templates', $this);
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl(conversionName: 'thumb')
        );
    }

    public function postImage(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl(conversionName: 'medium')
        );
    }

    public function fullImage(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl(conversionName: 'large')
        );
    }

    protected static function booted()
    {
        self::retrieved(function (self $page) {
            $page->setAsset(vite('resources/css/app.css', 'tallAdmin'), 'css');
            $page->setAsset(vite('resources/js/app.js', 'tallAdmin'), 'js');

            return $page;
        });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop('crop-center', 300, 300);

        $this->addMediaConversion('medium')
            ->width(818)
            ->height(409);

        $this->addMediaConversion('large')
            ->width(1366)
            ->height(768);

        $this->addMediaConversion('x-large')
            ->width(1920)
            ->height(1080);
    }

    public function isActive(): bool
    {
        return $this->deleted_at == null;
    }
}
