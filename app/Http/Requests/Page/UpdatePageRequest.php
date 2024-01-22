<?php

namespace App\Http\Requests\Page;


use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ];
    }
}
