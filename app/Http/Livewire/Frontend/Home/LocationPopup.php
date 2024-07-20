<?php

namespace App\Http\Livewire\Frontend\Home;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LocationPopup extends Component
{
    public array $company_address_components = [];

    public $popularStates = [];

    public function render()
    {
        return view('frontend.home.location-popup');
    }

    public function getHasSavedLocationProperty()
    {
        $location = getSavedLocation();
        
        return !empty($location['lat']) && !empty($location['lng']);
    }
}
