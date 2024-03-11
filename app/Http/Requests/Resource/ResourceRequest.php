<?php

namespace App\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;

use function App\Helpers\stakeholder_id;

class ResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->isMethod('post'))
            $this->merge([
                'stakeholder_id' => stakeholder_id(),
            ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stakeholder_id' => ['required','string','sometimes','exists:stakeholders,id'],
            'resource' => ['required','string','sometimes'],
            'quantity' => ['required','sometimes'],
            'is_avilable' => ['sometimes','boolean'],
            'notes' => ['required','string','sometimes']
        ];
    }
}
