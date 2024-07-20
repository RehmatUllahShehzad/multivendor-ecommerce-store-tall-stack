<?php

namespace App\Services\GoogleApi;

use App\Classes\LatLng;
use Illuminate\Support\Facades\Http;

class GoogleApiService
{
    public string $apiKey = '';

    public string $apiPath = 'https://maps.googleapis.com/maps/api/geocode/json';

    public function __construct()
    {
        $this->apiKey = config('services.google.map.api_key');
    }

    public function validateAddress(string $zipcode, string $stateName): bool
    {
        $addressComponents = Http::get($this->apiPath, [
            'key' => $this->apiKey,
            'address' => $zipcode,
        ])->json('results.0.address_components');

        if (! $addressComponents) {
            return false;
        }

        foreach ($addressComponents as $addressComponent) {
            if ($addressComponent['long_name'] == $stateName) {
                return true;
            }
        }

        return false;
    }

    public function getCoordinates(string $address)
    {
        $location = (object) Http::get($this->apiPath, [
            'key' => $this->apiKey,
            'address' => $address,
        ])->json('results.0.geometry.location');

        return new LatLng($location->lat, $location->lng);
    }
}
