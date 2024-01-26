<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class NotificationSettingRequest extends BaseRequest
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
                'notification_state' => ['nullable', 'in:none,observation,forecasting'],
                'notification_level' => ['nullable', 'in:none,normal,medium,high'],
                'notification_priorities' => ['required', 'in:none,top,low,high'],
                'is_on' => ['required', 'sometimes', 'boolean'],
                'note' => ['nullable', 'string'],
            ];

        }
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'main_category_id' => ['required', 'uuid', 'exists:categories,id'],
            'sub_category_id' => ['required', 'uuid', 'exists:categories,id'],
            'notification_state' => ['nullable', 'in:none,observation,forecasting'],
            'notification_level' => ['nullable', 'in:none,normal,medium,high'],
            'notification_priorities' => ['required', 'in:none,top,low,high'],
            'is_on' => ['required', 'sometimes', 'boolean'],
            'note' => ['nullable', 'string'],
        ];

    }


    public function attributes()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'main_category_id' => 'Main Category ID',
            'sub_category_id' => 'Sub Category ID',
            'notification_state' => 'Notification State',
            'notification_level' => 'Notification Level',
            'notification_priorities' => 'Notification Priorities',
            'is_on' => 'Is On',
            'note' => 'Note'
        ];
    }
}
