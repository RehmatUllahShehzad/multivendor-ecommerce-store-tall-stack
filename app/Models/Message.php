<?php

namespace App\Models;

use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
{
    use HasFactory,
        InteractsWithMedia,
        MediaConversions {
            MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
        }

    protected $fillable = ['conversation_id', 'message', 'sender_id', 'receiver_id'];

    /**
     * Relation: Message belongsTo Conversation
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Relation: Conversation belongsTo Messages
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relation: Conversation belongsTo Messages
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeRead(Builder $builder, User $receiver, bool $isRead = true): Builder
    {
        return $builder->where('is_read', $isRead)->where('receiver_id', $receiver->id);
    }

    public function isReadBy(User $user): bool
    {
        return $this->receiver_id == $user->id && $this->is_read;
    }
}
