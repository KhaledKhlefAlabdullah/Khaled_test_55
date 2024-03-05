<?php

namespace App\Http\Requests\Posts;


use App\Http\Requests\BaseRequest;

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

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'tag' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
            'media' => ['sometimes', 'nullable', 'file','mimes:pdf,pptx,png,jpg,jpeg,etc'],
            'is_priority' => ['sometimes', 'nullable', 'boolean'],
            'priority_count' => ['sometimes', 'nullable', 'integer'],
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
