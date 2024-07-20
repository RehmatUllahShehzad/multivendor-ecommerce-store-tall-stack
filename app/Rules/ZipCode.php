<?php

namespace App\Rules;

use App\Models\State;
use App\Services\GoogleApi\GoogleApiService;
use Illuminate\Contracts\Validation\Rule;

class ZipCode implements Rule
{
    private ?State $state;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stateId)
    {
        $this->state = State::find($stateId);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $googleApiService = new GoogleApiService();

        return $googleApiService->validateAddress($value, $this->state->name);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter the zipcode of the selected state';
    }
}
