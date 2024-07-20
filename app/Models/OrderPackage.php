<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Enums\OrderStatus;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class OrderPackage extends Model implements Ownable
{
    use HasFactory,
        HasRelationships;

    protected $guarded = [];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'meta' => 'array',
        'status' => OrderStatus::class,
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
                    ->orWhereRelation('order', 'order_number', 'LIKE', "%$part%")
                    ->orWhereRelation('order.customer', 'first_name', 'LIKE', "%$part%")
                    ->orWhereRelation('order.customer', 'last_name', 'LIKE', "%$part%");
            }
        });
    }

    public function scopeOfVendor(Builder $builder, User $user): Builder
    {
        return $builder->where('vendor_id', $user->id);
    }

    public function scopeCompleted(Builder $builder): Builder
    {
        return $builder->where('status', OrderStatus::Completed);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customer(): HasOneDeep
    {
        return $this->hasOneDeep(User::class, [
            Order::class,
            Cart::class,
        ], [
            'id', 'id', 'id',
        ], [
            'order_id', 'cart_id', 'user_id',
        ]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderPackagesItem::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function total()
    {
        return $this->sub_total + $this->shipping_fee;
    }

    public function vendorTotal()
    {
        return ($this->sub_total + $this->shipping_fee) - $this->service_fee;
    }

    public function isCompleted(): bool
    {
        return $this->status == OrderStatus::Completed;
    }

    public function isOwnedBy(Authenticatable $owner): bool
    {
        return $owner->id == $this->vendor_id;
    }
}
