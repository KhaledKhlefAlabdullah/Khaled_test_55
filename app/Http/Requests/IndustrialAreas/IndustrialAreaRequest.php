<?php

namespace App\Http\Requests\IndustrialAreas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

        $industrial_area_id = $this->route('id');

        return [
            'name' => 'required|string|min:5',
            'address' => 'required', 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'representative_name' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($industrial_area_id) {
                    return $query->where('industrial_area_id', '!=', $industrial_area_id);
                }),
            ]
        ];
    }
}
