<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DisasterReportRequest extends FormRequest
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
                'natural_disaster_id' => ['sometimes', 'required', 'uuid', 'exists:natural_disasters,id'],
                'entity_id' => ['nullable', 'uuid', 'exists:entities,id'],
                'shipment_id' => ['nullable', 'uuid', 'exists:shipments,id'],
                'supplier_id' => ['nullable', 'uuid', 'exists:suppliers,id'],
                'employee_id' => ['nullable', 'uuid', 'exists:employees,id'],
                'waste_id' => ['nullable', 'uuid', 'exists:wastes,id'],
                'is_safe' => ['sometimes', 'required', 'boolean'],
                'impact_date' => ['nullable', 'date'],
                'start_date' => ['nullable', 'date'],
                'stop_date' => ['nullable', 'date'],
            ];

        }

        return [
            'natural_disaster_id' => ['required', 'uuid', 'exists:natural_disasters,id'],
            'entity_id' => ['nullable', 'uuid', 'exists:entities,id'],
            'shipment_id' => ['nullable', 'uuid', 'exists:shipments,id'],
            'supplier_id' => ['nullable', 'uuid', 'exists:suppliers,id'],
            'employee_id' => ['nullable', 'uuid', 'exists:employees,id'],
            'waste_id' => ['nullable', 'uuid', 'exists:wastes,id'],
            'is_safe' => ['sometimes', 'required', 'boolean'],
            'impact_date' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'stop_date' => ['nullable', 'date'],
        ];

    }


    public function attributes()
    {
        return [
            'id' => 'ID',
            'natural_disaster_id' => 'Natural Disaster ID',
            'entity_id' => 'Entity ID',
            'shipment_id' => 'Shipment ID',
            'employee_id' => 'Employee ID',
            'supplier_id' => 'Supplier ID',
            'waste_id' => 'Waste ID',
            'is_safe' => 'Is Safe',
            'impact_date' => 'Impact Date',
            'start_date' => 'Start Date',
            'stop_date' => 'End Date',
        ];
    }
}
