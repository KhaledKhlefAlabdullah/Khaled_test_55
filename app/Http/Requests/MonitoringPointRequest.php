<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\ValidationRule;

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
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255', 'unique:monitoring_points,name'],
            'location' => ['required', 'string', 'max:255'],
            'point_type' => ['required', 'in:normal,high,dangerous'],
            'api_link' => ['nullable', 'url'],
            'is_custom' => ['sometimes', 'required', 'boolean'],
        ];
    }
}
