<?php

namespace App\Http\Requests\Dam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDamRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255',],
            'location' => ['sometimes', 'required', 'string', 'max:255',],
            'water_level' => ['sometimes', 'required', 'numeric',],
            'discharge' => ['sometimes', 'required', 'string',],
            'source' => ['nullable', 'string', 'max:255',]
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
            'name' => 'Name',
            'location' => 'Location',
            'water_level' => 'Water Level',
            'discharge' => 'Discharge',
            'source' => 'Source'
        ];
    }
}
