<?php

namespace App\Http\Requests\Timelines;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TimelineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'stakeholder_id' => auth()->user()->id,
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
            'stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'stakeholder_id' => 'Stakeholder'
        ];
    }
}
