<?php

namespace App\Helpers;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
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

