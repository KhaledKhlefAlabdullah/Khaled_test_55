<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'max:100', 'exists:users,id',],
            'title' => ['nullable', 'string'],
            'media_url' => ['required', 'string', 'url'],
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

