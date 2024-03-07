<?php

namespace App\Http\Requests\Timelines;

use App\Models\Timelines\Timeline;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use function App\Helpers\stakeholder_id;

class TimelineEventRequest extends FormRequest
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
        if ($this->isMethod('PUT')) {
            return [
                'category_id' => ['sometimes', 'required', 'string', 'exists:categories,id'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'start_date' => ['sometimes', 'required', 'date', 'after_or_equal:now'],
                'end_date' => ['sometimes', 'required', 'date', 'after:start_date'],
                'description' => ['nullable', 'string'],
                'production_percentage' => ['sometimes', 'required', 'numeric', 'min:0', 'max:100'],
                'is_active' => ['sometimes', 'required', 'boolean'],
                'resources' => ['sometimes','required','array']
            ];
        }
        return [
            'category_id' => ['required', 'string', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after_or_equal:now'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'description' => ['nullable', 'string'],
            'production_percentage' => ['required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'required', 'boolean'],
            'resources' => ['required','array']
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
