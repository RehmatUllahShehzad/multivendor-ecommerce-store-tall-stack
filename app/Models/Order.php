<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Enums\OrderStatus;
use App\Mail\ReviewAdded;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Order extends Model implements Ownable
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status'];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'meta' => 'array',
        // 'status' => OrderStatus::class,
    ];

    /**
     * Apply the basic search scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     * @return void
     */
    public function scopeSearchOrders($query, $term)
    {
        if (! $term) {
            return;
        }

        $query->where(function ($query) use ($term) {
            $parts = array_map('trim', explode(' ', $term));
            foreach ($parts as $part) {
                $query->where(($this->getTable()).'.id', 'LIKE', "%$part%")
                    ->orWhere('total_amount', 'LIKE', "%$part%")
                    ->orWhereRelation('customer', 'username', 'LIKE', "%$part%");
            }
        });
    }

    public function packages(): HasMany
    {
        return $this->hasMany(OrderPackage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(CartAddress::class, 'cart_id', 'cart_id')->whereType('shipping');
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(CartAddress::class, 'cart_id', 'cart_id')->whereType('billing');
    }

    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Cart::class, 'id', 'id', 'cart_id', 'user_id');
    }

    /**
     * Return the transactions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getPriceAttribute(): float
    {
        return $this->packages->sum(fn ($package) => $package->total());
    }

    public function getSubTotalAttribute(): float
    {

        return $this->packages->sum('sub_total');
    }

    public function getShippingFeeAttribute(): float
    {
        return $this->packages->sum('shipping_fee');
    }

    public function getServiceFeeAttribute(): float
    {
        return $this->packages->sum('service_fee');
    }

    public function getStatusAttribute(): OrderStatus
    {
        return $this->packages->every(fn ($package) => $package->status == OrderStatus::Completed)
            ? OrderStatus::Completed
            : OrderStatus::Processing;
    }

    /**
     * @param  \App\Models\User  $user
     */
    public function isOwnedBy(Authenticatable $user): bool
    {
        return $this->customer->id == $user->id;
    }

    public function isCompleted(): bool
    {
        return $this->status == OrderStatus::Completed;
    }

    public function hasReviewFor(Product $product)
    {
        return $this->reviews()->whereProductId($product->id)->exists();
    }

    public function addReview(Product $product, string $message, int $stars)
    {
        $review = $this->reviews()->create([
            'rating' => $stars,
            'comment' => $message,
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        try {
            Mail::send(new ReviewAdded($review));
        } catch (\Exception $exception) {
            session()->flash('error', 'Error'.$exception->getMessage());
        }

        return $review;
    }
}
