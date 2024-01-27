<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        $this->merge(['stakeholder_id' => Auth::id()]);
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
                'route_id' => ['sometimes', 'required', 'uuid', 'exists:entities,id'],
                'material_id' => ['required', 'uuid', 'exists:entities,id'],
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'slug' => ['nullable', 'string', 'unique'],
                'location' => ['sometimes', 'required', 'string'],
                'contact_info' => ['sometimes', 'required', 'string'],
                'is_available' => ['sometimes', 'required', 'boolean'],
            ];
        }
        return [
            'route_id' => ['required', 'uuid', 'exists:entities,id'],
            'material_id' => ['required', 'uuid', 'exists:entities,id'],
            'stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'public_id' => ['required', 'unique', 'integer'],
            'slug' => ['nullable', 'string', 'unique'],
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
            'slug' => 'Slug',
            'location' => 'Location',
            'contact_info' => 'Contact Info',
            'is_available' => 'Is Available'
        ];
    }
}
