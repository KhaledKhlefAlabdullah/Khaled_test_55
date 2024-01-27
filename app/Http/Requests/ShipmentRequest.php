<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShipmentRequest extends FormRequest
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
                'product_id' => ['sometimes', 'required', 'uuid', 'exists:entities,id'],
                'customer_id' => ['sometimes', 'required', 'uuid', 'exists:entities,id'],
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'location' => ['sometimes', 'required', 'string'],
                'contact_info' => ['sometimes', 'required', 'string']
            ];
        }
        return [
            'stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'route_id' => ['required', 'uuid', 'exists:entities,id'],
            'product_id' => ['required', 'uuid', 'exists:entities,id'],
            'customer_id' => ['required', 'uuid', 'exists:entities,id'],
            'public_id' => ['required', 'unique', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string'],
            'contact_info' => ['required', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'route_id' => 'Route',
            'product_id' => 'Product',
            'customer_id' => 'Customer',
            'stakeholder_id' => 'Stakeholder',
            'public_id' => 'Public ID',
            'name' => 'Name',
            'description' => 'Description',
            'location' => 'Location',
            'contact_info' => 'Contact Info'
        ];
    }


}
