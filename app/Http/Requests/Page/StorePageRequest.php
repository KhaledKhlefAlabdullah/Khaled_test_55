<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'user_id' => ['required', 'string', 'exists:users,id', 'uuid'],
            'title' => ['required', 'string', 'max:255',],
            'type' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string', 'max:255',],
            'phone_number' => ['nullable', 'string', 'max:255',],
            'location' => ['nullable', 'string', 'max:255',],
            'start_time' => ['nullable', 'date',],
            'end_time' => ['nullable', 'date',],
        ];


    }
}
