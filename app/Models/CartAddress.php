<?php

namespace App\Models;

use App\Classes\LatLng;
use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use stdClass;

class CartAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'object',
    ];

    public function scopeAddressType(Builder $builder, AddressType $type): Builder
    {
        return $builder->whereType($type);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function getLatLngAttribute()
    {
        return isset($this->meta->latLng)
            ? new LatLng($this->meta->latLng->lat, $this->meta->latLng->lng)
            : null;
    }

    public function setLatLngAttribute(LatLng $latLng = null)
    {
        $meta = $this->meta ?? new stdClass();
        $meta->latLng = $latLng;

        $this->meta = $meta;
    }
}
