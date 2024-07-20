<?php

namespace App\Models;

use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MenuItem extends Model implements HasMedia
{
    use HasFactory,
        InteractsWithMedia,
        MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'parent_id', 'title', 'icon', 'link', 'order', 'is_active'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (self $menuItem) {
            if ($menuItem->children->isEmpty()) {
                return;
            }

            foreach ($menuItem->children as $subMenu) {
                $subMenu->delete();
            }
        });
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    public function scopeRoot(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeDefaultOrder(Builder $builder): Builder
    {
        return $builder->orderBy('order', 'ASC');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this
            ->hasMany(self::class, 'parent_id')
            ->defaultOrder();
    }

    public function getThumbnailUrl(?string $default = '/frontend/images/default.jpeg')
    {
        return $this->getFirstMediaUrl('thumbnail', 'small') ?: $default;
    }

    public function setOrder(int $order): bool
    {
        return $this->update([
            'order' => $order,
        ]);
    }
}
