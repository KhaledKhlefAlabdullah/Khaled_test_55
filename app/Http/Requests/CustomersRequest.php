<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
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
            'customer_name' => 'required|string',
            'shiped_product_id' => 'required|string|exists:entities,id',
            'location' => 'required|string',
            'reoute_id' => 'required|string|exists:entities,id',
            'phone_number' => 'required|string|regex:/^\+?[0-9]{9,20}$/'
        ];
    }
}
