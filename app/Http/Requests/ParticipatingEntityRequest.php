<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ParticipatingEntityRequest extends FormRequest
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
        if ($this->method() === 'PUT') {
            return [
                'title' => ['nullable', 'string'],
                'media_url' => ['sometimes', 'required', 'url'],
                'media_type' => ['nullable', 'in:image,video,file,website_URL']
            ];
        }
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id',],
            'title' => ['nullable', 'string'],
            'media_url' => ['required', 'url'],
            'media_type' => ['nullable', 'in:image,video,file,website_URL']
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
            'title' => 'Title',
            'media_url' => 'Media URL',
            'media_type' => 'Media Type'
        ];
    }
}

