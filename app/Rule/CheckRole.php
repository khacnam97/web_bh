<?php

namespace App\Rule;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

class CheckRole implements Rule
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
        $roleId = Role::pluck('id')->all();
        return in_array($value,$roleId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.Check role');;
    }
}
