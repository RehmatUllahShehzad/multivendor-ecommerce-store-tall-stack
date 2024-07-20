<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\DTO\Payments\PaymentMethod as PaymentMethodDto;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model implements Ownable
{
    use HasFactory;

    protected $guarded = [];

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

    public function isPrimary(): bool
    {
        return $this->is_primary ?? false;
    }

    /**
     * Convert Payment method DTO to this models instance
     */
    public function createFromDto(PaymentMethodDto $paymentMethod): self
    {
        return $this->fill([
            'payment_method_id' => $paymentMethod->id,
            'name' => $paymentMethod->name,
            'card_number' => $paymentMethod->cardNumber,
            'exp_year' => $paymentMethod->expYear,
            'exp_month' => $paymentMethod->expMonth,
        ]);
    }

    /**
     * @param  \App\Models\User  $user
     */
    public function isOwnedBy(Authenticatable $user): bool
    {
        return $this->user_id == $user->id;
    }
}
