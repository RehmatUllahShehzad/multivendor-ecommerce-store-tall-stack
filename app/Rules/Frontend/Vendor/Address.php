<?php

namespace App\Rules\Frontend\Vendor;

use Illuminate\Contracts\Validation\Rule;

class Address implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return ! empty($value['formattedAddress'])
            && ! empty($value['coordinates']['lat'])
            && ! empty($value['coordinates']['lng']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be selected from the google suggestion.';
    }
}
