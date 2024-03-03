<?php

namespace App\Http\Requests\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Data preparation before validation.
     */
    protected function prepareForValidation()
    {
        // Set sender_id based on the current user making the request
        $this->merge(['sender_id' => Auth::id()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('PUT')) 
        {
            return [
                'message' => ['required', 'string', 'max:255'],
            ]; 
        }
        return [
            'receiver_id' => ['required', 'string', 'exists:users,id'],
            'chat_id' => ['required', 'string', 'exists:chats,id'],
            'message' => ['required', 'string', 'max:255'],
            'media' => ['sometimes', 'file', 'mimes:png.jpg,jpeg,gif,mp4'],
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
            'sender_id' => 'Sender',
            'receiver_id' => 'Receiver',
            'chat_id' => 'Chat',
            'message' => 'Message',
            'media_url' => 'Media URL',
            'message_type' => 'Message Type',
            'is_read' => 'Read',
            'is_edit' => 'edit',
            'is_starred' => 'Starred',
        ];
    }
}
