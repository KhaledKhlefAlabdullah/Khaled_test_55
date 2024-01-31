<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BaseRequest extends FormRequest
{

    /**
     * Data preparation before validation.
     */
    protected function prepareForValidation()
    {
        // Set user_id based on the current user making the request
        $this->merge(['user_id' => Auth::id()]);
    }
}
