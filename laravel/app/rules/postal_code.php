<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Postal_code implements Rule
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
        return $this->isValidPostalCode($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The postal code field does not have a valid format.');
    }

    public function isValidPostalCode($postal_code)
    {
        $postalCodRegEx = '/^[0-9]{5}$/i';

        if (preg_match($postalCodRegEx, $postal_code)) {
            return true;
        }

        return false;
    }
}
