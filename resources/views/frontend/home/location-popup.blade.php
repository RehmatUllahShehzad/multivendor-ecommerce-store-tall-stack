<div wire:ignore.self class="modal fade" id="location-popup" tabindex="-1" aria-labelledby="location-popupLabel"
    aria-hidden="true">
    <div class="modal-dialog review-modal-main location-modal">
        <div class="modal-content">
            <a href="" data-bs-dismiss="modal">X</a>
            <div class="review-modal modal-search-wrap" x-data="locationPopup">
                <h3 class="text-center">Select Your Location</h3>
                <div class="input-group input-group-sm mt-5 mb-3" @address-changed="addressChanged">
                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <x-frontend.google-address-autocomplete class="form-control pac-target-input" id="full_address" />

                    @error('company_address_components')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>
                <div class="set-location-wrap" style="cursor: pointer;" @click="searchByCurrentLocation">
                    <div class="location-icon current-location-search">
                        <span class="span-hide">a</span>
                    </div>
                    <div class="set-location-content">
                        <h4>
                            Select my location
                        </h4>
                        <p>
                            we will show you items near you sorted by distance
                        <div class="error" x-show="error" x-text="error"></div>
                        </p>
                    </div>
                </div>

                @if (count($popularStates))
                    <div class="locations-list">
                        <h5>Popular</h5>
                        <ul>
                            @foreach ($popularStates as $state)
                                <li><a
                                        href="{{ route('products.index', ['location' => $state['coordinates']]) }}">{{ $state['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@pushOnce('page_js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('locationPopup', () => ({
                error: null,
                url: "{{ html(urldecode(route('products.index', ['location' => ['lat' => ':lat', 'lng' => ':lng']]))) }}",

                searchByCurrentLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            position => {
                                let {
                                    latitude,
                                    longitude
                                } = position.coords;
                                
                                this.redirect({
                                    lat: latitude,
                                    lng: longitude
                                });
                            },
                            error => {
                                this.error = error.message;
                            }
                        );
                    }
                },

                addressChanged({
                    detail
                }) {
                    if (!detail.coordinates.lat || !detail.coordinates.lng) {
                        return
                    }

                    this.redirect(detail.coordinates)
                },

                redirect({
                    lat,
                    lng
                }) {
                    window.location = this.url.replace(':lat', lat).replace(':lng', lng);
                },
            }))
        });

        @if(! $this->hasSavedLocation)
            jQuery(document).ready(function($) {
                $("#location-popup").modal('show');
            });
        @endif
    </script>
@endpushOnce
