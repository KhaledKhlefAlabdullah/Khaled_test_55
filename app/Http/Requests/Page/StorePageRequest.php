<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StorePageRequest extends BaseRequest
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
            'user_id' => ['required', 'string', 'max:255', 'exists:users,id',],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'User',
            'title' => 'Title',
            'type' => 'Type',
            'description' => 'Description',
            'phone_number' => 'Phone Number',
            'location' => 'Location',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
    }
}
