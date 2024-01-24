<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\ValidationRule;

class NotificationRequest extends BaseRequest
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
        if ($this->isMethod('POST')) {
            return [
                'user_id' => ['required', 'uuid', 'exists:users,id'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:255'],
                'slug' => ['nullable', 'string', 'max:255'],
                'is_read' => ['required', 'boolean'],
                'notification_type' => ['required', 'in:email,sms,notification'],
            ];
        }
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'is_read' => ['sometimes', 'required', 'boolean'],
            'notification_type' => ['sometimes', 'required', 'in:email,sms,notification'],
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'slug' => 'Slug',
            'is_read' => 'Is Read',
            'notification_type' => 'Notification Type',
        ];
    }
}
