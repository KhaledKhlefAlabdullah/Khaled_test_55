<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateCategoryRequest extends StoreCategoryRequest
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
     * Add validation rules for 'name' and 'type' fields in the 'rules' method
     *
     * In the 'rules' method of [StoreCategoryRequest], validation rules for the 'name' and 'type' fields have been added.
     * The 'name' field is set to be sometimes required, of string type, and with a maximum length of 255 characters.
     * The 'type' field is also set to be sometimes required and should have a value from the specified enum options ('Post', 'News', 'File', 'Notification', 'Report', 'Timeline_event', 'entity').
     * These rules are merged with the parent class rules and returned.
     * @return array<string, ValidationRule|array<mixed>|string>
     *
     */
    public function rules(): array
    {

        $parentRules = parent::rules();

        $customRules = [
            'name' => ['sometimes', 'required', 'string', 'unique:categories,name', 'max:255'],
        ];

        return array_merge($parentRules, $customRules);

    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }
}
