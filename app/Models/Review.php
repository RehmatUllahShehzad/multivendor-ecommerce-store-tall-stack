<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Enums\ReviewStatus;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Review extends Model implements Ownable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => ReviewStatus::class,
    ];

    protected $appends = ['short_comment'];

    public function scopeApproved(Builder $builder): Builder
    {
        return $builder->whereStatus(ReviewStatus::APPROVED);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Intract with the product title
     */
    public function getShortCommentAttribute()
    {
        return Str::limit($this->comment, 150, ' ...');
    }

    public function isOwnedBy(Authenticatable $owner): bool
    {
        return $this->user_id == $owner->id;
    }

    public function isNew(): bool
    {
        return $this->is_new;
    }

    public function setNew(bool $value = true): bool
    {
        return $this->update([
            'is_new' => $value,
        ]);
    }

    public function setStatus(ReviewStatus $status): bool
    {
        return $this->update([
            'status' => $status,
        ]);
    }

    public function isPending(): bool
    {
        return $this->status == ReviewStatus::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status == ReviewStatus::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status == ReviewStatus::REJECTED;
    }

    public function status()
    {
        return ucfirst($this->status->value);
    }
}
