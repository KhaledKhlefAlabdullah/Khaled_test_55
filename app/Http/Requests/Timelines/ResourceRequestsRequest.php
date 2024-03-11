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
        if($this->isMethod('post'))
            $this->merge([
                'sender_stakeholder_id' => stakeholder_id(),
                'receiver_stakeholder_id' => $this->get_receiver_id()
            ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   
        if($this->isMethod('put')){
            return [
                'state' => ['boolean']
            ];
        }
        
        return [
            'sender_stakeholder_id' => ['required', 'string', 'exists:stakeholders,id'],
            'receiver_stakeholder_id' => ['required', 'string', 'exists:stakeholders,id'],
            'resource_id' => ['required', 'string', 'exists:resources,id'],
            'quantity' => ['required', 'numeric','max:'.$this->get_resource_quantity()]
        ];
    }

    public function get_resource_quantity(){
        return Resource::findOrFail(request()->input('resource_id'))->value('quantity');
    }

    public function get_receiver_id(){
        return Resource::findOrFail(request()->input('resource_id'))->value('stakeholder_id');
    }
}
