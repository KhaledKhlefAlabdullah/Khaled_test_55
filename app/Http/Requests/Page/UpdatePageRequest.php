<?php

namespace App\Http\Requests\Page;


class UpdatePageRequest extends StorePageRequest
{


    public function rules(): array
    {
        $parentRules = parent::rules();

        $customRules = [
            'user_id' => ['sometimes', 'required', 'string', 'max:255', 'exists:users,id', 'uuid'],
            'title' => ['sometimes', 'required', 'max:255', 'string'],
            'type' => ['sometimes', 'required', 'max:255', 'string'],
        ];

        return array_merge($parentRules, $customRules);
    }
}
