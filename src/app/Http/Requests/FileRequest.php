<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class FileRequest extends BaseRequest
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
                'file_type' => ['sometimes', 'required', 'in:Education,Manuals & Plans,Other'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'description' => ['sometimes', 'required', 'string', 'max:255'],
                'version' => ['nullable', 'string', 'max:100'],
                'media_url' => ['nullable', 'string', 'url'],
                'media_type' => ['nullable', 'in:image,video,file'],
                'update_frequency' => ['nullable', 'in:daily,weekly,monthly'],
            ];

        }

        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'file_type' => ['required', 'in:Education,Manuals,Plans'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:100'],
            'media_url' => ['nullable', 'string', 'url'],
            'media_type' => ['nullable', 'in:image,video,file'],
            'update_frequency' => ['nullable', 'in:daily,weekly,monthly'],
        ];

    }

    public function attributes()
    {
        return [
            'user_id' => 'User',
            'file_type' => 'File Type',
            'title' => 'Title',
            'description' => 'Description',
            'version' => 'Version',
            'media_url' => 'Media URL',
            'media_type' => 'Media Type',
            'update_frequency' => 'Update Frequency',
        ];
    }
}
