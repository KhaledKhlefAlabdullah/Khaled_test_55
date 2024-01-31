<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\ValidationRule;

/*
 * @extends BaseRequest
 */

class MonitoringPointRequest extends BaseRequest
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
                'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:monitoring_points,name'],
                'location' => ['sometimes', 'required', 'string', 'max:255'],
                'point_type' => ['sometimes', 'required', 'in:normal,high,dangerous'],
                'api_link' => ['nullable', 'url'],
                'is_custom' => ['sometimes', 'required', 'boolean'],
                'water_level' => ['nullable', 'numeric'],
                'risk_indicators' => ['nullable', 'string'],
                'discharge' => ['nullable', 'string'],
                'source' => ['nullable', 'string'],
            ];

        }

        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255', 'unique:monitoring_points,name'],
            'location' => ['required', 'string', 'max:255'],
            'point_type' => ['required', 'in:normal,high,dangerous'],
            'api_link' => ['nullable', 'url'],
            'is_custom' => ['sometimes', 'required', 'boolean'],
            'water_level' => ['nullable', 'numeric'],
            'risk_indicators' => ['nullable', 'string'],
            'discharge' => ['nullable', 'string'],
            'source' => ['nullable', 'string'],
        ];

    }


    public function attributes()
    {
        return [
            'user_id' => 'User',
            'name' => 'Name',
            'location' => 'Location',
            'point_type' => 'Point Type',
            'api_link' => 'API Link',
            'is_custom' => 'Is Custom',
            'water_level' => 'Water Level',
            'risk_indicators' => 'Risk Indicators',
            'discharge' => 'Discharge',
            'source' => 'Source'
        ];
    }
}
