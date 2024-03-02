<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\ValidationRule;

class PostRequest extends BaseRequest
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
        if ($this->isMethod('PUT')) {
            return [
                'page_id' => ['sometimes', 'required', 'uuid', 'exists:pages,id'],
                'category_id' => ['sometimes', 'required', 'uuid', 'exists:categories,id'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'body' => ['sometimes', 'required', 'string'],
                'media_url' => ['nullable', 'url'],
                'media_type' => ['nullable', 'string', 'in:image,video,file'],
                'is_priority' => ['nullable', 'boolean'],
                'priority_count' => ['nullable', 'integer'],
                'is_general_news' => ['sometimes', 'required', 'boolean'],
                'is_publish' => ['sometimes', 'required', 'boolean']
            ];
        }

        return [
            'page_id' => ['required', 'uuid', 'exists:pages,id'],
            'category_id' => ['required', 'uuid', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'media_url' => ['nullable', 'url'],
            'media_type' => ['nullable', 'string', 'in:image,video,file'],
            'is_priority' => ['nullable', 'boolean'],
            'priority_count' => ['nullable', 'integer'],
            'is_general_news' => ['sometimes', 'required', 'boolean'],
            'is_publish' => ['sometimes', 'required', 'boolean']
        ];
    }


    public function attributes()
    {
        return [
            'user_id' => 'User',
            'page_id' => 'Page',
            'category_id' => 'Category',
            'title' => 'Title',
            'body' => 'Body',
            'media_url' => 'Media URL',
            'media_type' => 'Media Type',
            'is_priority' => 'Priority',
            'priority_count' => 'Priority Count',
            'is_general_news' => 'General News',
            'is_publish' => 'Publish'
        ];
    }

}
