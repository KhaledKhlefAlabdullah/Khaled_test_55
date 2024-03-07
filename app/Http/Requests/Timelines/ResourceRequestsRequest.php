<?php

namespace App\Http\Requests\timelines;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

use function App\Helpers\stakeholder_id;

class ResourceRequestsRequest extends FormRequest
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
        $this->merge([
            'sender_stakeholder_id' => stakeholder_id(),
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
            'sender_stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'receiver_stakeholder_id' => ['required', 'uuid', 'exists:stakeholders,id'],
            'resource_id' => ['required', 'uuid', 'exists:resources,id'],
            'quantity' => ['required', 'float','max:'.$this->get_resource_quantity()]
        ];
    }

    public function get_resource_quantity(){
        return Resource::where('id',request()->input('resource_id'))->quantity;
    }
}
