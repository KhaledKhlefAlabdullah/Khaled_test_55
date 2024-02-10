<?php

namespace App\Http\Requests\MonitorinPoints;

use Illuminate\Foundation\Http\FormRequest;

class MainMonitoringPointRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5',
            'location' => 'required|string|min:5',
            'level' => 'nullable|string|in:normal,high,dangerous',
            'is_custom' => 'nullable|boolean',
            'api_link' => 'nullable|url'
        ];
    }
}
