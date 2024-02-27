<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use function App\Helpers\stakeholder_id;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Data preparation before validation.
     */
    protected function prepareForValidation()
    {
        // Set user_id based on the current user making the request
        $this->merge(['stakeholder_id' => stakeholder_id()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'PUT') {
            return [
                'route_id' => ['sometimes', 'required', 'string', 'exists:entities,id'],
                'material_id' => ['required', 'string', 'exists:entities,id'],
                'name' => ['sometimes', 'required', 'string','unique:suppliers,public_id'],
                'location' => ['sometimes', 'required', 'string'],
                'contact_info' => ['sometimes', 'required', 'string'],
                'is_available' => ['sometimes', 'required', 'boolean'],
            ];
        }
        return [
            'route_id' => ['required', 'string', 'exists:entities,id'],
            'material_id' => ['required', 'string', 'exists:entities,id'],
            'stakeholder_id' => ['required', 'string', 'exists:stakeholders,id'],
            'name' => ['required', 'string','unique:suppliers,public_id'],
            'location' => ['required', 'string'],
            'contact_info' => ['required', 'string'],
            'is_available' => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'route_id' => 'Route',
            'material_id' => 'Material',
            'stakeholder_id' => 'Stakeholder',
            'public_id' => 'Public',
            'location' => 'Location',
            'contact_info' => 'Contact Info',
            'is_available' => 'Is Available'
        ];
    }
}
