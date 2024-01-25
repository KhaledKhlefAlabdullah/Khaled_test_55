<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Service_validation_request extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stakeholder_id' => 'required|string|exists:stakeholders,id',
            'category_id' => 'required|string|exists:categories,id',
            'infrastructures_state' => 'required|string',
            'slug' => 'required|string|',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ];
    }
}
