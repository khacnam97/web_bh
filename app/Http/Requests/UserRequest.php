<?php

namespace App\Http\Requests;

use App\Rule\CheckRole;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $password;
    private $role_id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if(auth()->user()->id == $this->id){
            return [
                'username'          => 'required|unique:users,username,'.$this->id,
                'phone_number'      => 'nullable|regex:/^([0-9]+([-]?[0-9]+)*)?$/'
            ];
        }
        if($this->id){
            return [
                'role_id'           => ['required', new CheckRole],
                'username'          => 'required|unique:users,username,'.$this->id,
                'phone_number'      => 'nullable|regex:/^([0-9]+([-]?[0-9]+)*)?$/'
            ];
        }
        return [
            'role_id'           => ['required', new CheckRole],
            'password'          => 'required|min:8',
            'username'          => 'required|unique:users,username,'.$this->id,
            'phone_number'      => 'nullable|regex:/^([0-9]+([-]?[0-9]+)*)?$/'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'username'          => __('user.User name'),
            'password'          => __('user.Password'),
            'role_id'           => __('user.Role'),
            'full_name'         => __('user.Full Name'),
            'phone_number'      => __('user.Phone Number'),
        ];
    }
}
