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
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'version' => ['sometimes','required', 'string'],
            'version_id' => ['sometimes','string','required','exists:files,version_id'],
            'file' => ['sometimes', 'mimes:pdf,pptx,jpg,jpeg,png,gif,mp4,mp3'],
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
