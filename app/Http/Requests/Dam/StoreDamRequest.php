<?php

namespace App\Http\Requests\Dam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDamRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',],
            'location' => ['required', 'string', 'max:255',],
            'water_level' => ['required', 'numeric',],
            'discharge' => ['required', 'string',],
            'source' => ['nullable', 'string', 'max:255',]
        ];
    }
}
