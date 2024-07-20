<?php

namespace App\Models;

use App\DTO\Payments\Customer;
use App\Managers\PaymentManager;
use App\Traits\OwnsModels;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property-read \App\Models\Vendor $vendor
 * @property string $id
 * @property string $name
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasSlug;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;
    use InteractsWithMedia;
    use OwnsModels;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'is_admin',
        'stripe_customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendorRequests(): HasMany
    {
        return $this->hasMany(VendorRequest::class);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id');
    }

    public function withdrawAccount(): HasOne
    {
        return $this->hasOne(WithdrawAccount::class, 'id');
    }

    public function isVendor(): bool
    {
        return (bool) $this->vendor;
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function vendorOrders(): HasMany
    {
        return $this->hasMany(OrderPackage::class, 'vendor_id');
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Cart::class);
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, OrderPackage::class, 'vendor_id', 'order_id', 'id', 'order_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function conversations(): HasManyDeep
    {
        return $this->hasManyDeep(Conversation::class, [
            Cart::class,
            Order::class,
            OrderPackage::class,
        ]);
    }

    public function messages(): HasManyDeep
    {
        return $this->hasManyDeep(Message::class, [
            Cart::class,
            Order::class,
            OrderPackage::class,
            Conversation::class,
        ]);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($this->first_name).' '.ucfirst($this->last_name),
        );
    }

    public function profileImage(): Attribute
    {
        return new Attribute(
            fn ($value) => 'https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82'
        );
    }

    public function hasPendingVendorRequest(): bool
    {
        return $this->vendorRequests()->pending()->exists();
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
        $parts = explode(' ', $term);
        foreach ($parts as $part) {
            $query->where('email', 'LIKE', "%$part%")
                ->orWhere('first_name', 'LIKE', "%$part%")
                ->orWhere('last_name', 'LIKE', "%$part%");
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('username');
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function createStripeCustomer()
    {
        if (! $this->stripe_customer_id) {

            $response = app(PaymentManager::class)->driver('stripe')->createCustomer(new Customer(
                id: Str::random(10),
                name: $this->name,
                email: $this->email,
            ));

            throw_if(
                ! $response->success,
                Exception::class,
                trans('exceptions.payment_attach_exception')
            );

            /** @var \App\DTO\Payments\Customer */
            $customer = $response->data;

            $this->update([
                'stripe_customer_id' => $customer->id,
            ]);
        }
    }
}
