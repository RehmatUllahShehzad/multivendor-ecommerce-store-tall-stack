<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Models\Admin\Category;
use App\Models\Admin\DietaryRestriction;
use App\Models\Admin\Nutrition;
use App\Models\Admin\Unit;
use App\Traits\MediaConversions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia, Ownable
{
    protected $table = 'products';

    use HasFactory,
        HasSlug,
        SoftDeletes,
        InteractsWithMedia,
        MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    public function scopeOfUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
    }

    public function scopeIsVendorPickup(Builder $builder): Builder
    {
        return $builder->whereRelation('user.vendor', 'deliver_products', false);
    }

    public function scopeFeatured(Builder $builder): Builder
    {
        return $builder->where('is_featured', 1);
    }

    public function scopePublished(Builder $builder, bool $is_published = true): Builder
    {
        return $builder->where('is_published', $is_published);
    }

    public function scopeWithAvgRating(Builder $builder): Builder
    {
        return $builder->withAvg('approvedReviews', 'rating');
    }

    public function scopeWithDistanceFrom(Builder $builder, float $lat, float $lng): Builder
    {
        $vendorTable = (new Vendor())->getTable();
        $productTable = $this->getTable();

        return $builder
            ->join("{$vendorTable} AS vt", 'user_id', '=', 'vt.id')
            ->select("{$productTable}.*", 'vt.deliver_up_to_max_miles')
            ->selectRaw("
                (
                    3960
                    * ACOS(
                        COS(RADIANS('{$lat}')) 
                        * COS(RADIANS(`vt`.`company_address_lat`))
                        * COS(
                            RADIANS(`vt`.`company_address_lng`)
                            - RADIANS('{$lng}')
                        )
                        + SIN(RADIANS('{$lat}')
                    )
                    * SIN(RADIANS(`vt`.`company_address_lat`)))
                ) AS distance
            ");

        //The distance is in miles
    }

    public function scopeNearTo(Builder $builder, float $lat, float $lng): Builder
    {
        return $builder
            ->withDistanceFrom($lat, $lng)
            ->havingRaw('distance is NULL OR distance <= vt.deliver_up_to_max_miles')
            ->oldest('distance');
    }

    public function loadAvgRating()
    {
        if(is_null($this->approved_reviews_avg_rating)) {
            $this->loadAvg('approvedReviews', 'rating');
        }
    }

    public function productViews(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }

    public function orderPackagesItems(): HasMany
    {
        return $this->hasMany(OrderPackagesItem::class);
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
                $query->where('title', 'LIKE', "%$part%")
                    ->orWhere('slug', 'LIKE', "%$part%");
            }
        });
    }

    /**
     * Apply the basic date range scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $range
     * @return void
     */
    public function scopeDateFilter($query, $range)
    {
        if (empty($range)) {
            return;
        }

        if (isset($range[0])) {
            $query->whereDate('created_at', '>=', $range[0]);
        }

        if (isset($range[1]) && $range[1] != '...') {
            $query->whereDate('created_at', '<=', $range[1]);
        }

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function nutritions(): BelongsToMany
    {
        return $this->belongsToMany(Nutrition::class)->withPivot('unit_id', 'value');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function dietaryRestrictions(): BelongsToMany
    {
        return $this->belongsToMany(DietaryRestriction::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->approved();
    }

    /**
     * @param  \App\Models\User  $user
     */
    public function isOwnedBy(Authenticatable $user): bool
    {
        return $this->user_id == $user->id;
    }

    public function getAvailableStock(): float
    {
        return $this->available_quantity;
    }

    public function canBuyQuantity(int $quantity): bool
    {
        $stock = $this->getAvailableStock();

        return is_null($stock) || $quantity <= $stock;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function addView()
    {
        if(Auth::check() && $this->isOwnedBy(Auth::user())) {
            return;
        }

        return $this->productViews()->create(['user_id' => Auth::id()]);
    }
}
