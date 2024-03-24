<?php

namespace App\Http\Requests;


use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\getIdByName;

class AnnouncementsRequest extends FormRequest
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
            'title' => ['string', 'sometimes', 'required'],
            'body' => ['string', 'sometimes', 'required'],
            'media_url' => ['nullable'],
            'is_publish' => ['boolean', 'sometimes'],
        ];
    }

    protected function prepareForValidation()
    {
        // Set user_id based on the current user making the request
        $this->merge([
            'user_id' => Auth::id(),
            'category_id' => getIdByName(Category::class, 'Announcements')
        ]);

    }
}
