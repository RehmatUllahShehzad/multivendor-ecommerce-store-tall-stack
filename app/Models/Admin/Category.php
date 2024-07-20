<?php

namespace App\Models\Admin;

use App\Models\Product;
use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    protected $guarded = [];

    public function scopeRoot(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeDefaultOrder(Builder $builder): Builder
    {
        return $builder->orderBy('sort_order', 'ASC');
    }

    public function scopeFeatured(Builder $builder): Builder
    {
        return $builder->where('is_featured', '1');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order', 'ASC');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function setOrder(int $order): bool
    {
        return $this->update([
            'sort_order' => $order,
        ]);
    }

    protected static function booting(): void
    {
        self::creating(function (self $category) {
            $category->slug = Str::of($category->name)->slug();
        });
    }

    /**
     * Apply the basic search scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     * @return void
     */
    public function scopeSearch($query, $term)
    {
        if (! $term) {
            return;
        }

        $query->where(function ($query) use ($term) {
            $parts = array_map('trim', explode(' ', $term));
            foreach ($parts as $part) {
                $query->where('name', 'LIKE', "%$part%");
            }
        });
    }
}
