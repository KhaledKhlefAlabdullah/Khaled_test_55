<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'id' => ['uuid'],
            'user_id' => ['required', 'string', 'exists:users,id',],
            'title' => ['required', 'string',],
            'type' => ['required', 'string',],
            'description' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'string'],
            'location' => ['nullable', 'string'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ];
    }
}
