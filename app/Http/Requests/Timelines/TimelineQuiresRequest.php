<?php

namespace App\Http\Requests\Timelines;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use function App\Helpers\stakeholder_id;

class TimelineQuiresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'stakeholder_id' => stakeholder_id(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'timeline_event_id' => ['required', 'string', 'exists:timeline_events,id'],
            'stakeholder_id' => ['required', 'string', 'exists:stakeholders,id'],
            'inquiry' => ['required', 'string', 'max:255'],
        ];
    }


    public function attributes(): array
    {
        return [
            'timeline_event_id' => 'Timelines Event',
            'stakeholder_id' => 'Stakeholder',
            'inquiry' => 'Inquiry',
        ];
    }
}
