<?php


namespace App\Http\Requests;


use App\Models\Script;
use App\Rule\pyFileValidate;
use App\Rule\uniqueFileValidate;
use Illuminate\Foundation\Http\FormRequest;

class ScriptRequest extends FormRequest
{
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
        if($this->id && ( !\File::exists($this->fileName) || Script::where('id',$this->id)->value('fileName') === $this->fileName->getClientOriginalName() )) {
            return [
                'name'          => 'required|unique:scripts,name,'.$this->id,
                'isActive'      => 'nullable|numeric',
            ];
        }
        return [
            'name'          => 'required|unique:scripts,name,'.$this->id,
            'fileName'      => ['required', new pyFileValidate ,new uniqueFileValidate],
            'isActive'      => 'nullable|numeric',
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
            'name'          => __('script.Name'),
            'isActive'      => __('script.Status'),
            'fileName'      => __('script.File'),
        ];
    }
}
