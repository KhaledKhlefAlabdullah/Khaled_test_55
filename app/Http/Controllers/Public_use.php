<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;

class Public_use
{
    public static function fake_register_request(
        $industrial_area_id = null,
        $name = null,
        $email = null,
        $password = null,
        $password_confirmation = null,
        $phone_number = null,
        $contact_person = null,
        $stakeholder_type = null,
        $location = null,
        $representative_name = null,
        $job_title = null
    ) {
        $requestData = [
            'industrial_area_id' => $industrial_area_id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'phone_number' => $phone_number,
            'contact_person' => $contact_person,
            'stakeholder_type' => $stakeholder_type,
            'location' => $location,
            'representative_name' => $representative_name,
            'job_title' => $job_title,
        ];

        $request = Request::create('/api/register', 'POST', $requestData);

        // Create an instance of RegisteredUserController to use the register user function (store)
        $response = (new RegisteredUserController())->store($request);

        return $response;
    }
}
