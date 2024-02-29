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
                'category_id' => ['sometimes','required','string','exists:categories,id'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'description' => ['sometimes', 'required', 'string', 'max:255'],
                'version' => ['nullable', 'string', 'max:100'],
                'file' => ['nullable', 'file', 'mimes:pdf,pptx,jpg,jpeg,png,gif,mp4,mp3'],
                'update_frequency' => ['sometimes', 'in:daily,weekly,monthly'],
            ];

        }

        return [
            'category_id' => ['required','string','exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:100'],
            'file' => ['required', 'mimes:pdf,jpg,jpeg,png,gif,mp4,mp3'],
            'update_frequency' => ['sometimes', 'in:daily,weekly,monthly'],
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
