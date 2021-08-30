<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Rule\MatchOldPassword;

class ChangePasswordRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $password;

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
        return [
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
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
            'current_password'      => __('user.Current Password'),
            'password'              => __('user.Password New'),
            'password_confirmation' => __('user.Password Confirmation')
        ];
    }
}
