<?php

namespace App\Rules;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PasswordValidator implements Rule
{
    private ?User $user;

    private bool $matchWithExisting;

    private string $password_validation_error = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user = null, bool $matchWithExisting = false)
    {
        $this->user = $user;

        $this->matchWithExisting = $matchWithExisting;
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
        if (! preg_match('(.*[a-z].*)', $value) || ! preg_match('(.*[A-Z].*)', $value) || ! preg_match("(.*\d.*)", $value) || ! preg_match('/^[^\s]+(\s+[^\s]+)*$/', $value)) {
            $this->password_validation_error = 'Password must contain atleast one uppercase, one lowercase and one digit & no blank spaces.';

            return false;
        }
        if (! $this->matchWithExisting) {
            return true;
        }
        if (! $this->user) {
            throw new Exception('Invalid user. Please provide a user when password match is required');
        }
        if (! Hash::check($value, $this->user->password)) {
            return true;
        }
        $this->password_validation_error = 'Current and new password cannot be same.';

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->password_validation_error;
    }
}
