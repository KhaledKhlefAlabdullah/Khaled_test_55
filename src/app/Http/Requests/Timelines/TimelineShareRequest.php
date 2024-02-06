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
     * Prepare the data for validation.
     *
     * This method is called before the validation process.
     * It merges default values into the request data.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Merge default values into the request data

        // Set the 'send_stakeholder_id' to the ID of the currently authenticated user
        $this->merge([
            'send_stakeholder_id' => auth()->user()->id,

            // Set the 'timeline_id' to the ID of the timeline associated with the authenticated user
            'timeline_id' => Timeline::where('stakeholder_id', auth()->user()->id)->value('id'),
        ]);
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
                'status' => ['sometimes', 'required', 'string', 'in:accept,reject,pending'],
                'end_date' => ['nullable', 'date'],
            ];
        }
        return [
            'timeline_id' => ['required', 'uuid', 'exists:timelines,id'],
            'send_stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,'],
            'receive_stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,'],
            'status' => ['sometimes', 'required', 'string', 'in:accept,reject,pending'],
            'send_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
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
