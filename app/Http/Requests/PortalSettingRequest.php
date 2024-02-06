<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class PortalSettingRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'PUT') {
            return [
                'key' => ['sometimes', 'required', 'string', 'max:255'],
                'value' => ['sometimes', 'required',]
            ];
        }
        return [
            'user_id' => ['required', 'string', 'max:100', 'exists:users,id',],
            'key' => ['required', 'string', 'max:255',],
            'value' => ['required',]
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'User',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
}
