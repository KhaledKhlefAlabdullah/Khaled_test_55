<?php

namespace App\Http\Requests\Page;


class UpdatePageRequest extends StorePageRequest
{


    public function rules(): array
    {
        $parentRules = parent::rules();

        $customRules = [
            'user_id' => ['nullable', 'string', 'exists:users,id', 'uuid'],
            'title' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
        ];

        return array_merge($parentRules, $customRules);
    }
}
