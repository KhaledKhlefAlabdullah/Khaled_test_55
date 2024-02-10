<?php

namespace App\Http\Requests\IndustrialAreas;

use Illuminate\Foundation\Http\FormRequest;

class IndustrialAreaRequest extends FormRequest
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
            'name' => 'required|string|min:5',
            'address' => 'required', 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'representative_name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email'
        ];
    }
}
