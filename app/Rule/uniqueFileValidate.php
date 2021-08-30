<?php

namespace App\Rule;

use App\Models\Script;
use Illuminate\Contracts\Validation\Rule;

class uniqueFileValidate implements Rule
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
        $fileNames = Script::pluck('fileName')->all();
        return !in_array($value->getClientOriginalName(),$fileNames);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.This file name already exists.');
    }
}
