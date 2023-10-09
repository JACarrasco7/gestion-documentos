<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Phone implements Rule
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
        //Phone 2 is not required. if phone 2 is empty, this not is validate
        if ($attribute == 'phone_2' && $value == '') {
            return true;
        }else{
            return $this->isValidPhone($value);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The telephone field does not have a valid format.');
    }

    public function isValidPhone($data)
    {
        $phoneRegEx = '/^[0-9]{9}$/i';

        if (preg_match($phoneRegEx, $data)) {
            return true;
        }

        return false;
    }
}
