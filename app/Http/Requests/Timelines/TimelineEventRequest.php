<?php

namespace App\Http\Requests\Timelines;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TimelineEventRequest extends FormRequest
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
        if ($this->isMethod('PUT')) {
            return [
                'category_id' => ['sometimes', 'required', 'uuid', 'exists:categories,id'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'start_date' => ['sometimes', 'required', 'date', 'after_or_equal:now'],
                'end_date' => ['sometimes', 'required', 'date', 'after:start_date'],
                'description' => ['nullable', 'string'],
                'production_percentage' => ['sometimes', 'required', 'numeric', 'min:0', 'max:100'],
                'is_active' => ['sometimes', 'required', 'boolean'],
            ];
        }
        return [
            'timeline_id' => ['required', 'uuid', 'exists:timelines,id'],
            'stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'category_id' => ['required', 'uuid', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after_or_equal:now'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'description' => ['nullable', 'string'],
            'production_percentage' => ['required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'ID',
            'timeline_id' => 'Timelines',
            'stakeholder_id' => 'Stakeholder',
            'category_id' => 'Category',
            'title' => 'Title',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'description' => 'Description',
            'production_percentage' => 'Production Percentage',
            'is_active' => 'Active'
        ];
    }
}
