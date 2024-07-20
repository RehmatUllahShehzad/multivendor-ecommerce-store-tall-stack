<?php

namespace App\Models;

use App\Contracts\Ownable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model implements Ownable
{
    use HasFactory;

    protected $guarded = [];

    public function scopeOfUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
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
                $query->where('summary', 'LIKE', "%$part%");
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

    /**
     * Return the states relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Return the states relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Return the states relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * @param  \App\Models\User  $user
     */
    public function isOwnedBy(Authenticatable $user): bool
    {
        return $this->user_id == $user->id;
    }
}
