<?php

namespace App\Helpers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Mail\PortalMails;
use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Translation\Exception\NotFoundResourceException;




/**
 * Get an Eloquent model instance by its ID and perform a existence check.
 *
 * This helper function retrieves an instance of the specified Eloquent model
 * by its ID. If the instance is not found, a NotFoundResourceException is thrown.
 *
 * @param string $model The fully qualified class name of the Eloquent model.
 * @param mixed $id The ID of the model to retrieve.
 * @return Model The retrieved Eloquent model instance.
 *
 * @throws NotFoundResourceException If the model instance is not found.
 */
if (!function_exists('getAndCheckModelById')) {
    function getAndCheckModelById($model, $id)
    {
        $instance = $model::find($id);

        if (!$instance) {
            throw new NotFoundResourceException($model . ' not found', 404);
        }

        return $instance;
    }
}

if (!function_exists('getIdByName')) {
    function getIdByName($model, $name)
    {
        $instance_id = $model::where('name',$name)->first()->id;

        if (!$instance_id) {
            throw new NotFoundResourceException($model . ' not found or there no '.$name, 404);
        }

        return $instance_id;
    }
}

/**
 * Transform a collection of Eloquent models using a specified resource class.
 *
 * This helper function checks if the collection contains a single item,
 * and then either creates a resource instance for that item or returns
 * a collection of resource instances for the entire collection.
 *
 * @param Collection $collection
 * @param string $resourceClass
 * @return JsonResource|AnonymousResourceCollection
 */
if (!function_exists('transformCollection')) {
    function transformCollection(Collection $collection, $resourceClass): JsonResource|AnonymousResourceCollection
    {
        return ($collection->count() == 1)
            ? new $resourceClass($collection->first())
            : $resourceClass::collection($collection);
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
    ): Response|JsonResponse|RedirectResponse
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
    function store_files($file, $path): string
    {
        // get file extension
        $file_extension = $file->getClientOriginalExtension();

        // rename the file
        $file_name = time() . '.' . $file_extension;

        // store the in public directory
        $file->move($path, $file_name);

        // return the path and file name
        return $path . '/' . $file_name;

    }
}

if (!function_exists('edit_file')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
    function edit_file($old_file_path, $new_file, $path): string
    {
        // Delete the old file from storage
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }

        // Store the new file
        $new_file_path = store_files($new_file, $path);

        return $new_file_path;
    }

}

if (!function_exists('edite_page_details')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
    function edit_page_details($request,$page_type): Response|JsonResponse
    {
        try{
            // validate the input data
            $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'phone_number' =>  'required|string|regex:/^[0-9]{9,20}$/',
                'location' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]);

            // check if there page us page already in database
            $page = Page::where('type',$page_type)->first();

            if(empty($page)){

                // if it's empty get the auth user id
                $user_id = Auth::id();

                // create the page us page with user id and validated data
                $page = Page::create([
                    'user_id' => $user_id,
                    'title' => $request->input('title'),
                    'type' => $page_type,
                    'description' => $request->input('description'),
                    'phone_number' => $request->input('phone_number'),
                    'location' => $request->input('location'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time')
                ]);

            }else{

                // if it's not empty and there already page in database update the page with the validated data
                $page->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'phone_number' => $request->input('phone_number'),
                    'location' => $request->input('location'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time')
                ]);

            }

            return response()->json([
                'page' => $page,
                'message' => __('Successfully editing page us details')
            ],200);

        }
        catch (\Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in adding the page details')
            ],500);

        }
    }

}

if (!function_exists('send_mail')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
    function send_mail($mail_message,$receiver)
    {
        try{

            return Mail::to($receiver)->send(new PortalMails($mail_message));
        }
        catch (\Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Cold not sending the email')
            ],500);

        }
    }
}

if(!function_exists('stakeholder_id')){

    function stakeholder_id()
    {
        try{
            return Auth::user()->stakeholder()->first()->id;
        }
        catch (\Exception $e){
            return \response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There no stake holder')
            ],500);
        }
    }

}
