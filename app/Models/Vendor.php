<?php

namespace App\Models;

use App\Classes\LatLng;
use App\Enums\ShippingType;
use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Vendor extends Model implements HasMedia
{
    use HasFactory,
        HasSlug,
        InteractsWithMedia,
        MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    protected $guarded = [];

    protected $appends = ['company_address_components'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('vendor_name')
            ->saveSlugsTo('vendor_slug');
    }

    protected static function booting()
    {
        self::saving(function (self $vendor) {
            $vendor->deliver_up_to_max_miles = intval($vendor->deliver_up_to_max_miles) ?: null;
            $vendor->express_delivery_rate = floatval($vendor->express_delivery_rate) ?: null;
            $vendor->standard_delivery_rate = floatval($vendor->standard_delivery_rate) ?: null;
        });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    public function setCompanyAddressComponentsAttribute($components)
    {
        $this->company_address = $components['formattedAddress'] ?? null;
        $this->company_address_lat = $components['coordinates']['lat'] ?? null;
        $this->company_address_lng = $components['coordinates']['lng'] ?? null;
    }

    public function getCompanyAddressComponentsAttribute()
    {
        return [
            'formattedAddress' => $this->company_address,
            'coordinates' => [
                'lat' => $this->company_address_lat,
                'lng' => $this->company_address_lng,
            ],
        ];
    }

    public function distanceFromLocation(LatLng $location)
    {
        $latFrom = deg2rad($location->lat);
        $lonFrom = deg2rad($location->lng);
        $latTo = deg2rad($this->company_address_lat);
        $lonTo = deg2rad($this->company_address_lng);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        return 3960 * 2 * asin(
            sqrt(
                pow(sin($latDelta / 2), 2)
                    + cos($latFrom)
                    * cos($latTo)
                    * pow(sin($lonDelta / 2), 2)
            )
        );
    }

    public function getShippingOptions(LatLng $location = null): array
    {
        $shippingOptions = [
            [
                'type' => ShippingType::PICKUP->value,
                'name' => 'Pickup',
                'value' => 0,
            ],
        ];

        if (
            ! $this->deliver_products
            || ($location
                && $this->distanceFromLocation($location) > $this->deliver_up_to_max_miles
            )
        ) {
            return $shippingOptions;
        }

        return array_merge(
            $shippingOptions,
            [
                [
                    'type' => ShippingType::STANDARD_DELIVERY->value,
                    'name' => 'Standard Delivery',
                    'value' => $this->standard_delivery_rate,
                ],
                [
                    'type' => ShippingType::EXPRESS_DELIVERY->value,
                    'name' => 'Express Delivery',
                    'value' => $this->express_delivery_rate,
                ],
            ]
        );
    }
}
