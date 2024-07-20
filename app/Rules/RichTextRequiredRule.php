<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RichTextRequiredRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private ?int $max = null, private ?int $min = null)
    {

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
        $content = strip_tags($value);

        if (empty($content)) {
            return false;
        }

        if ($this->min && strlen($content) < $this->min) {
            return false;
        }

        if ($this->max && strlen($content) > $this->max) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The field is required and should be between {$this->min} and {$this->max} characters long.";
    }
}
