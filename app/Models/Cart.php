<?php

namespace App\Models;

use App\Services\Cart\CartManager;
use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Cart extends Model
{
    use HasFactory;

    /**
     * The cart total.
     *
     * @var null|\App\DataTypes\Price
     */
    public $total = null;

    /**
     * The cart sub total.
     *
     * @var null|\App\DataTypes\Price
     */
    public $subTotal = null;

    /**
     * The cart tax total.
     *
     * @var null|\App\DataTypes\Price
     */
    public $taxTotal = null;

    /**
     * The discount total.
     *
     * @var null|float
     */
    public float $discountTotal = 0;

    /**
     * All the tax breakdowns for the cart.
     *
     * @var Collection
     */
    public Collection $taxBreakdown;

    /**
     * The shipping total for the cart.
     *
     * @var float
     */
    public float $shippingTotal = 0;

    /**
     * Return a new factory instance for the model.
     *
     * @return \App\Database\Factories\CartFactory
     */
    protected static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }

    /**
     * Define which attributes should be
     * protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime',
        'meta' => 'object',
    ];

    /**
     * Return the cart items relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    /**
     * Return the user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function scopeUnmerged($query)
    {
        return $query->whereNull('merged_id');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNull('completed_at');
    }

    public function scopeNotCompleted($query)
    {
        return $query->whereNull('completed_at');
    }

    /**
     * Return the order relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Return the addresses relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(CartAddress::class, 'cart_id');
    }

    /**
     * Return the shipping address relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shippingAddress()
    {
        return $this->hasOne(CartAddress::class, 'cart_id')->whereType('shipping');
    }

    /**
     * Return the billing address relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billingAddress()
    {
        return $this->hasOne(CartAddress::class, 'cart_id')->whereType('billing');
    }

    /**
     * Return the saved cart relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function savedCart()
    {
        return $this->hasOne(SavedCart::class);
    }

    /**
     * Return the cart manager.
     *
     * @return \App\Services\Cart\CartManager
     */
    public function getManager()
    {
        return new CartManager($this);
    }

    /**
     * Apply scope to get active cart.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        return $query->whereDoesntHave('order');
    }
}
