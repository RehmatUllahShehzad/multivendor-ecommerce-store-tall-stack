<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Enums\AddressType;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model implements Ownable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'address_type' => AddressType::class,
    ];

    public function scopeOfUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
    }

    public function scopePrimary(Builder $builder, bool $primary = true): Builder
    {
        return $builder->where('is_primary', $primary);
    }

    /**
     * @param  array<int>  $ids
     */
    public function scopeExcept(Builder $builder, array $ids = []): Builder
    {
        return $builder->whereNotIn('id', $ids);
    }

    public function ofUser(User $user): Builder
    {
        return Address::query()->where('user_id', $user->id);
    }

    public function isPrimary(): bool
    {
        return $this->is_primary ?? false;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): belongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @param  \App\Models\User  $user
     */
    public function isOwnedBy(Authenticatable $user): bool
    {
        return $this->user_id == $user->id;
    }
}
