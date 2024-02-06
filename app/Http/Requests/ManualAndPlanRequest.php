<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class ManualAndPlanRequest extends BaseRequest
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
            'user_id' => ['uuid', 'required', 'exists:users,id'],
            'file_type' => ['in:Manuals & Plans'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'version' => ['nullable', 'string'],
            'media_rul' => ['nullable', 'string']

        ];
    }
}
