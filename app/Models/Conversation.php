<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Conversation extends Model
{
    use HasFactory,
        HasRelationships;

    protected $fillable = ['order_package_id'];

    /**
     * Relation: Conversation HasMany Messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function orderPackage(): BelongsTo
    {
        return $this->belongsTo(OrderPackage::class);
    }

    /**
     * Relation: Conversation HasMany Messages
     */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function user(): HasOneDeep
    {
        return $this
            ->hasOneDeep(
                User::class,
                [OrderPackage::class, Order::class, Cart::class],
                ['id', 'id', 'id', 'id'],
                ['order_package_id', 'order_id', 'cart_id', 'user_id']
            );
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(Order::class, OrderPackage::class, 'id', 'id', 'order_package_id', 'order_id');
    }

    public function vendor(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, OrderPackage::class, 'id', 'id', 'order_package_id', 'vendor_id');
    }
}
