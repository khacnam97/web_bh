<?php

namespace App\Rule;

use Illuminate\Contracts\Validation\Rule;

class pyFileValidate implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if($value->getClientOriginalExtension() == 'py' || $value->getClientOriginalExtension() == 'pyc' || $value->getClientOriginalExtension() == 'txt'){
            return true;
        }
        else return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.Check file python');
    }
}
