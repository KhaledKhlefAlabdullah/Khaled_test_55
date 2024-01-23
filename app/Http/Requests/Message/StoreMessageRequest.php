<?php

namespace App\Http\Requests\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMessageRequest extends FormRequest
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
        return [
            'sender_id' => ['required', 'uuid', 'exists:users,id'],
            'receiver_id' => ['required', 'uuid', 'exists:users,id'],
            'chat_id' => ['required', 'uuid', 'exists:chats,id'],
            'message' => ['required', 'string', 'max:255'],
            'media_url' => ['nullable', 'string', 'url', 'max:255'],
            'message_type' => ['nullable', 'in:text,image,video'],
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
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'chat_id' => 'Chat ID',
            'message' => 'Message',
            'media_url' => 'Media URL',
            'message_type' => 'Message Type',
            'is_read' => 'Is Read',
            'is_edite' => 'Is Edite',
            'is_starred' => 'Is Starred',
        ];
    }
}
