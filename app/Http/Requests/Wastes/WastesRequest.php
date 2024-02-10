<?php

namespace App\Http\Requests\Wastes;

use Illuminate\Foundation\Http\FormRequest;

class WastesRequest extends FormRequest
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
            'waste' => 'required|string',
            'disposal_location_id' => 'required|string|exists:entities,id',
            'route_id' => 'required|string|exists:entities,id'
        ];
    }
}
