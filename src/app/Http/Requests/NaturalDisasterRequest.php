<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NaturalDisasterRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'disaster_type' => ['nullable', 'string', 'max:255'],
                'disaster_date' => ['nullable', 'date'],
                'description' => ['nullable', 'string', 'max:255'],
                'location' => ['nullable', 'string', 'max:255'],
            ];

        }
        return [
            'name' => ['required', 'string', 'max:255'],
            'disaster_type' => ['nullable', 'string', 'max:255'],
            'disaster_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ];

    }


    public function attributes()
    {
        return [
            'name' => 'Name',
            'disaster_type' => 'Disaster Type',
            'disaster_date' => 'Disaster Date',
            'description' => 'Disaster Description',
            'location' => 'Location'
        ];
    }
}
