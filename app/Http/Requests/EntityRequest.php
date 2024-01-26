<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntityRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        // Set user_id based on the current user making the request
        $this->merge(['stakeholder_id' => Auth::id()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        if ($this->method() == 'PUT') {
            return [
                'category_id' => ['sometimes', 'required', 'uuid', 'exists:categories,id'],
                'name' => ['sometimes', 'required', 'string', 'max:100'],
                'slug' => ['sometimes', 'required', 'string', 'max:100', 'unique:entities,slug'],
                'public_id' => ['sometimes', 'required', 'integer', 'unique:entities,public_id'],
                'phone_number' => ['nullable', 'string', 'max:100', 'unique:entities,phone_number'],
                'location' => ['nullable', 'string', 'max:255'],
                'from' => ['nullable', 'string', 'max:255'],
                'to' => ['nullable', 'string', 'max:255'],
                'usage' => ['nullable', 'string', 'max:255'],
                'quantity' => ['nullable', 'boolean',],
                'is_available' => ['nullable', 'boolean',],
                'available_quantity' => ['nullable', 'boolean',],
                'note' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:255'],
            ];

        }
        return [
            'stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'category_id' => ['required', 'uuid', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:entities,slug'],
            'public_id' => ['required', 'integer', 'unique:entities,public_id'],
            'phone_number' => ['nullable', 'string', 'max:100', 'unique:entities,phone_number'],
            'location' => ['nullable', 'string', 'max:255'],
            'from' => ['nullable', 'string', 'max:255'],
            'to' => ['nullable', 'string', 'max:255'],
            'usage' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'boolean',],
            'is_available' => ['nullable', 'boolean',],
            'available_quantity' => ['nullable', 'boolean',],
            'note' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ];


    }


    /*
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @param array
     */
    public function attributes(): array
    {
        return [
            'id' => 'ID',
            'stakeholder_id' => 'Stakeholder ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'public_id' => 'Public ID',
            'phone_number' => 'Phone Number',
            'location' => 'Location',
            'from' => 'From',
            'to' => 'To',
            'usage' => 'Usage',
            'quantity' => 'Quantity',
            'is_available' => 'Is Available',
            'available_quantity' => 'Available Quantity',
            'note' => 'Note',
            'description' => 'Description',
        ];
    }
}
