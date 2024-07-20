<?php

namespace App\Classes;

class LatLng
{
    public function __construct(
        public float $lat,
        public float $lng
    ) {
    }
}
