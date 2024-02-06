<?php

namespace App\Http\Requests\Dam;

use App\Http\Requests\BaseRequest;

class StoreDamRequest extends BaseRequest
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
            'user_id' => ['required', 'string', 'max:255', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255',],
            'location' => ['required', 'string', 'max:255',],
            'water_level' => ['required', 'numeric',],
            'discharge' => ['required', 'string',],
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
            'user_id' => 'User ID',
            'name' => 'Name',
            'location' => 'Location',
            'water_level' => 'Water Level',
            'discharge' => 'Discharge',
            'source' => 'Source',
        ];
    }
}
