<?php

namespace App\Helpers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Mail\PortalMails;
use App\Models\Notifications\NotificationsSetting;
use App\Models\Page;
use App\Notifications\PortalNotifications;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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
        $instance_id = $model::where('name', $name)->first()->id;

        if (!$instance_id) {
            throw new NotFoundResourceException($model . ' not found or there no ' . $name, 404);
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
    function transformCollection($collection, $resourceClass): LengthAwarePaginator
    {
        // Check if $collection is an instance of LengthAwarePaginator
        if ($collection instanceof LengthAwarePaginator) {
            // Transform the items and return the paginator
            return new LengthAwarePaginator(
                $resourceClass::collection($collection->getCollection()),
                $collection->total(),
                $collection->perPage(),
                $collection->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Otherwise, assume it's an instance of Illuminate\Database\Eloquent\Collection
        return ($collection->count() == 1)
            ? new $resourceClass($collection->first())
            : $resourceClass::collection($collection);
    }
}

if (!function_exists('fake_register_request')) {
    /*
     * This function is used to add new user using register function
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

        // store the file in public directory
        $file->move(public_path($path), $file_name);

        // return the path and file name
        return $path . '/' . $file_name;

    }
}

if (!function_exists('edit_file')) {

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
   
    function edit_page_details($request, $page_type): Response|JsonResponse
    {
        try {
            // validate the input data
            $request->validate([
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'phone_number' => 'nullable|string|regex:/^\+?[0-9]{9,20}$/',
                'location' => 'nullable|string',
                'start_time' => 'nullable|date',
                'end_time' => 'nullable|date|after:start_time'
            ]);

            // check if there page us page already in database
            $page = Page::where('type', $page_type)->first();

            if (empty($page)) {

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
                    'end_time' => $request->input('end_time'),
                ]);

            } else {

                // if it's not empty and there already page in database update the page with the validated data
                $page->update([
                    'title' => is_null($request->input('title')) ? $page->title : $request->input('title'),
                    'description' => is_null($request->input('description')) ? $page->description : $request->input('description'),
                    'phone_number' => is_null($request->input('phone_number')) ? $page->phone_number : $request->input('phone_number'),
                    'location' => is_null($request->input('location')) ? $page->location : $request->input('location'),
                    'start_time' => is_null($request->input('start_time')) ? $page->start_time : $request->input('start_time'),
                    'end_time' => is_null($request->input('end_time')) ? $page->end_time : $request->input('end_time')
                ]);

            }

            //            $data = [
            //                'phone_number' => $page->phone_number,
            //                'location' => $page->location,
            //                'start_time' => $page->start_time,
            //                'end_time' => $page->end_time
            //            ];

            return response()->json([
                'message' => __('Successfully editing contact us page details'),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in adding the page details'),
            ], 500);

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
    function send_mail($mail_message, $receiver)
    {
        try {

            Mail::to($receiver)->send(new PortalMails($mail_message));
            
            return true;
        
        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Cold not sending the email'),
            ], 500);

        }
    }
}
/*
 * This function  return stakeholder id because it used many times in defirents places
 */
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
/**
 * This Function it get the instance by any value inside it
 */
if(!function_exists('get_instances_with_value'))
{
    function get_instances_with_value($model, $value)
    {

        $instance = $model::where('id',$value)->first();
        if(is_null($instance))
        {
            // Query the database to retrieve instances where any attribute has the specified value
            $instance = $model::where(function ($query) use ($model, $value) {
                $modelInstance = new $model(); // Create an instance of the model
                $fillableAttributes = $modelInstance->getFillable(); // Get fillable attributes of the model
                foreach ($fillableAttributes as $attribute) {
                    $query->orWhere($attribute, $value); // Add OR condition for each attribute
                }
            })->first();
        }

        return $instance;
    }


}


/**
 * This function is update the instance with keys and values passed to it
 */
if(!function_exists('find_and_update')){
     function find_and_update($model, $search_param, $keys, $values)
    {

        // Ensure the number of keys and values match
        if (count($keys) !== count($values)) {
            throw new \InvalidArgumentException('Number of keys and values must be equal');
        }

        // Retrieve the model instance by searching for the value in any attribute
        $instances = get_instances_with_value($model, $search_param);

        // Create an associative array of keys and values
        $data = [];
        foreach ($keys as  $key) {
            $data[$key] = $values[$key];
        }

        // Update the model attributes with the provided data
        $instances->update($data);

        return $instances; // Return the updated instances
    }
}

/**
 * Send notifications 
 */
if(!function_exists('send_notifications')){

    function send_notifications($receivers,array $viaChanel=['database'],$message){

        $user_profile = Auth::user()
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select('users.email', 'user_profiles.name', 'user_profiles.avatar_URL')
            ->first();
            
        Notification::send($receivers,new PortalNotifications($viaChanel,$user_profile,$message,$receivers));

    }
}

/**
 * Add notifications settings for user
 */
if (!function_exists('add_notifications_settings')) {

    function add_notifications_settings(string $type, string $user_id)
    {
        try {

            /*
             Weather:
                Report Weather
                Wind
                Rain

             Water Level:
                Dam (WE HAVE TO SELECT DAMS)
                Report Water
                Monitoring Point (WE HAVE TO SELECT MONITORING POINTS)

            Infrastructure Notification:
                Notifications

            Business Impact:
                Suppliers
                Production Site
                Shipments
                Employees
                Wastes
             */
            $data = [
                [
                    'main_category_id' => '008e8400-e29b-41d4-a716-446655440000',
                    'notification_settings' => [
                        ['sub_category_id' => '024e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '023e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '022e8400-e29b-41d4-a716-446655440000']
                    ]
                ],
                [
                    'main_category_id' => '025e8400-e29b-41d4-a716-446655440000',
                    'notification_settings' => [
                        ['sub_category_id' => '027e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '028e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '026e8400-e29b-41d4-a716-446655440000']
                    ]
                ],
                [
                    'main_category_id' => '029e8400-e29b-41d4-a716-446655440000',
                    'notification_settings' => [
                        ['sub_category_id' => '030e8400-e29b-41d4-a716-446655440000']
                    ]
                ]
            ];
            
            if (in_array($type, ['Tenant_company', 'Infrastructure_provider'])) {
                $extraItem = [
                    'main_category_id' => '031e8400-e29b-41d4-a716-446655440000',
                    'notification_settings' => [
                        ['sub_category_id' => '033e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '032e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '035e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '036e8400-e29b-41d4-a716-446655440000'],
                        ['sub_category_id' => '034e8400-e29b-41d4-a716-446655440000']
                    ]
                ];

                $data[] = $extraItem;
            }

            foreach ($data as $category) {
                // Iterate through the notification settings for this main category
                foreach ($category['notification_settings'] as $notification_setting) {
                    // Insert each notification setting related to this main category
                    NotificationsSetting::create([
                        'main_category_id' => $category['main_category_id'],
                        'user_id' => $user_id,
                        'sub_category_id' => $notification_setting['sub_category_id'],
                    ]);
                }
            }
        } catch (\Mockery\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('add-notifications-settings-error')
            ], 500);
        }
    }

}

/**
 * Get Counter
 */
if (!function_exists('count_items')) {

    function count_items($model, array $validations)
    {
        try {

            $item_count = $model::where($validations)->get()->count();

            return $item_count+1;
           
        } catch (\Mockery\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('get-count-error')
            ], 500);
        }
    }

}