<?php

namespace App\Helpers;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

if (!function_exists('getAndCheckModelById')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
    function getAndCheckModelById($model, $id)
    {
        $instance = $model::find($id);

        if (!$instance) {
            throw new NotFoundResourceException($model . " not found", 404);
        }

        return $instance;
    }
}

if (!function_exists('fake_register_request')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
     function fake_register_request(
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
    ): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     {
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

if (!function_exists('store_files')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
     function store_files($file,$path): string
     {
         // get file extension
         $file_extension = $file->getClientOriginalExtension();

         // rename the file
         $file_name = time().'.'.$file_extension;

         // store the in public directory
         $file->move($path, $file_name);

         // return the path and file name
         return $path.'/'.$file_name;

    }
}

