<?php

namespace App\Http\Requests\Notification;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class NotificationSettingRequest extends BaseRequest
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
       
        $rules = [
            'notification_state' => ['nullable', 'in:none,observation,forecasting'],
            'notification_priorities' => ['required', 'in:none,top,low,high'],
            'is_on' => ['required', 'sometimes', 'boolean'],
        ];

        if(request()->has('notification_level')){
            $rules['notification_level'] = ['nullable', 'in:none,normal,medium,high'];
        }

        if(request()->has('monitoring_points')){

            $monitoring_points = request()->input('monitoring_points');

            foreach($monitoring_points as $key => $point){
                $rules["monitoring_points.$key.id"] = ['required','string','exists:monitoring_points,id'];
            }

        }

        if(request()->has('dams')){

            $dams = request()->input('dams');

            foreach($dams as $key => $dam){
                $rules["dams.$key.id"] = ['required','string','exists:dams,id'];
            }

        }

        return $rules;
        
    }
}
