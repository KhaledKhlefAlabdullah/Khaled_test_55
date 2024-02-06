<?php

namespace App\Http\Requests\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
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
            'message' => ['sometimes', 'required', 'string', 'max:255'],
            'is_read' => ['nullable', 'boolean'],
            'is_edite' => ['nullable', 'boolean'],
            'is_starred' => ['nullable', 'boolean'],
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
            'is_read' => 'Is Read',
            'is_edite' => 'Is Edite',
            'is_starred' => 'Is Starred',
        ];
    }
}
