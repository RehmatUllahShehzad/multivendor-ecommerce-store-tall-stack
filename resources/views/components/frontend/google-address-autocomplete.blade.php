<input
    wire:ignore

    {{ $attributes->except(['wire:model', 'wire:model.defer']) }}

    x-data="googlePlacesAutocomplete"
    :value="address.formattedAddress"

    @blur="!selected && resetData()"
    @input="selected = false"
    @focus="element.setAttribute('autocomplete', 'new-password')"
>

<style>
    .pac-container.pac-logo{
        z-index: 10000;
    }
</style>

<script>
    function googleReady() {
        document.dispatchEvent(new Event('google:init'));
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('googlePlacesAutocomplete', () => ({
            address: @if($modelDefer) @entangle($modelDefer).defer @elseif($model) @entangle($model) @else '{}' @endif,
            element: null,
            autocomplete: null,
            selected: false,

            init() {
                this.element = this.$el;

                if (this.element === null) {
                    console.error(
                        "Cannot find Google Places Autocomplete input [x-ref=\"googleAutocomplete\"]"
                    );
                    return;
                }

                if (typeof window.google === 'undefined') {
                    document.addEventListener('google:init', () => {
                        this.initAutocomplete();
                    });
                } else {
                    this.initAutocomplete();
                }

                this.$watch('address', (address) => {
                    this.$dispatch('address-changed', address)
                })
            },

            resetData() {
                this.address = {
                    streetNumber: null,
                    streetName: null,
                    cityName: null,
                    stateAbbr: null,
                    zipCode: null,
                    coordinates: {
                        lat: null,
                        lng: null
                    },
                    state: null,
                    countryAbbr: null,
                    country: null,
                    formattedAddress: null,
                    resultRaw: null,
                };
            },

            initAutocomplete() {
                this.autocomplete = new window.google.maps.places.Autocomplete(this.element, {
                    types: ['geocode'],
                    componentRestrictions: { country: "us" },
                });
                
                this.autocomplete.addListener('place_changed', () => this.handleResponse());
            },

            handleResponse() {
                this.resetData();

                this.selected = true;

                const componentForm = {
                    street_number: 'short_name',
                    route: 'long_name',
                    locality: 'long_name',
                    administrative_area_level_1: 'short_name',
                    country: 'long_name',
                    postal_code: 'short_name',
                };

                const resultRaw = this.autocomplete.getPlace();
                
                const {
                    address_components,
                    formatted_address,
                    geometry: { location: { lat, lng } },
                } = resultRaw;
                
                const addressObject = {
                    streetNumber: '',
                    streetName: '',
                    cityName: '',
                    stateAbbr: '',
                    zipCode: '',
                    coordinates: { lat: lat(), lng: lng() },
                };

                // Need to loop over the results and create a friendly object
                for (let i = 0; i < address_components.length; i++) {
                    const addressType = address_components[i].types[0];
                    if (componentForm[addressType]) {
                        switch (addressType) {
                        case 'street_number':
                            addressObject.streetNumber = address_components[i].long_name;
                            break;
                        case 'route':
                            addressObject.streetName = address_components[i].long_name;
                            break;
                        case 'locality':
                            addressObject.cityName = address_components[i].long_name;
                            break;
                        case 'administrative_area_level_1':
                            addressObject.stateAbbr = address_components[i].short_name;
                            addressObject.state = address_components[i].long_name;
                            break;
                        case 'postal_code':
                            addressObject.zipCode = address_components[i].long_name;
                            break;
                        case 'country':
                            addressObject.countryAbbr = address_components[i].short_name;
                            addressObject.country = address_components[i].long_name;
                            break;
                        default:
                            break;
                        }
                    }
                }

                this.address = Object.assign({}, addressObject, {
                    formattedAddress: formatted_address,
                    resultRaw,
                });
            }
        }))
    })
</script>

<script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.map.api_key') }}&libraries=places&callback=googleReady"></script>
