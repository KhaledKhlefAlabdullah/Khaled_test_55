<?php

namespace App\Http\Requests\Timelines;

use App\Models\Timelines\Timeline;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TimelineShareRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'PUT') {
            return [
                'status' => ['sometimes', 'required', 'boolean'],
            ];
        }
        return [
            'receive_stakeholder_id' => ['required', 'string', 'exists:stakeholders,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'timeline_id' => 'Timelines',
            'send_stakeholder_id' => 'Sender',
            'receive_stakeholder_id' => 'Receiver',
            'status' => 'Status',
            'end_date' => 'End Date',
            'send_date' => 'Send Date',
        ];
    }
}
