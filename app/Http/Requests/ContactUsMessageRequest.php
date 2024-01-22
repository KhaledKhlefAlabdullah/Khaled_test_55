<?php

namespace App\Http\Requests;


class ContactUsMessageRequest extends BaseRequest
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
            'user_id' => ['required', 'string', 'max:100', 'exists:users,id',],
            'message' => ['required', 'string', 'max:255'],
            'is_read' => ['required', 'boolean'],
        ];
    }

}
