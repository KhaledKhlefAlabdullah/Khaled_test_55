<?php

namespace App\Http\Controllers\Notification;
use App\Models\DamsNotificationSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationSettingRequest;
use App\Models\MonitoringPointsNotificationSettings;
use App\Models\Notifications\NotificationsSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\find_and_update;
use function App\Helpers\getAndCheckModelById;

class NotificationsSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $user_id = Auth::id();

            // Retrieve notification settings data along with main category and subcategory information
            $notifications_settings = DB::table('notifications_settings')
                // Join the notifications_settings table with the categories table twice to get main and subcategories
                ->join('categories as main_category', 'notifications_settings.main_category_id', '=', 'main_category.id')
                ->join('categories as sub_categories', 'notifications_settings.sub_category_id', '=', 'sub_categories.id')
                // Select main category ID and name, renaming them for clarity
                ->select('main_category.id as main_category_id', 'main_category.name as main_category_name')
                // Aggregate notification settings IDs into a comma-separated string
                ->selectRaw('GROUP_CONCAT(notifications_settings.id) as notification_settings_ids')
                // Aggregate subcategory IDs into a comma-separated string
                ->selectRaw('GROUP_CONCAT(sub_categories.id) as sub_categories_ids')
                // Aggregate subcategory names into a comma-separated string
                ->selectRaw('GROUP_CONCAT(sub_categories.name) as sub_categories_name')
                // Aggregate notification states into a comma-separated string
                ->selectRaw('GROUP_CONCAT(notifications_settings.notification_state) as states')
                // Aggregate notification levels into a comma-separated string
                ->selectRaw('GROUP_CONCAT(notifications_settings.notification_level) as levels')
                // Aggregate notification priorities into a comma-separated string
                ->selectRaw('GROUP_CONCAT(notifications_settings.notification_priorities) as priorities')
                // Aggregate notification on/off states into a comma-separated string
                ->selectRaw('GROUP_CONCAT(notifications_settings.is_on) as on_off')
                // Filter the results by user ID
                ->where('notifications_settings.user_id', '=', $user_id)
                ->leftJoin('monitoring_points_notification_settings', 'notifications_settings.id', '=', 'monitoring_points_notification_settings.notifications_setting_id')
                ->leftJoin('monitoring_points', 'monitoring_points_notification_settings.monitoring_point_id', '=', 'monitoring_points.id')
                ->leftJoin('dams_notification_settings','notifications_settings.id','=','dams_notification_settings.notification_setting_id')
                ->leftJoin('dams','dams_notification_settings.dam_id','=','dams.id')
                ->selectRaw('GROUP_CONCAT(monitoring_points.name) as monitoing_point_name')
                ->selectRaw('GROUP_CONCAT(dams.name) as dam_name')
                // Group the results by main category ID and name
                ->groupBy('main_category.id', 'main_category.name')
                // Execute the query and retrieve the results
                ->get();


           // Process the retrieved data to separate aggregated strings into arrays and create individual objects
            $processed_data = $notifications_settings->map(function ($item) {
                return [
                    'main_category_id' => $item->main_category_id,
                    'main_category_name' => $item->main_category_name,
                    'notification_settings' => collect(explode(',', $item->notification_settings_ids))->map(function ($id, $index) use ($item) {
                        return [
                            'id' => $id,
                            'sub_category_id' => explode(',', $item->sub_categories_ids)[$index],
                            'sub_category_name' => explode(',', $item->sub_categories_name)[$index],
                            'monitoring_point' => explode(',',$item->monitoing_point_name),
                            'dams' => explode(',',$item->dam_name),
                            'state' => explode(',', $item->states)[$index],
                            'level' => explode(',', $item->levels)[$index],
                            'priority' => explode(',', $item->priorities)[$index],
                            'on_off' => explode(',', $item->on_off)[$index],
                        ];
                    }),
                ];
            });

            return response()->json([
                'data' => $processed_data,
                'message' => __('Successfully getting the notification setting data')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in getting the notifications setting6')
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationSettingRequest $request,string $id)
    {
        try {

            // get the validated data 
            $valid_data = $request->validated();

            // get the request keys
            $keys = array_diff($request->keys(), ['user_id']);
            
            // check if the request have monitoring points or dams
            if($request->has('monitoring_points') || $request->has('dams')){

                //except the monitoring points or dams  from keys array
                $keys = array_diff($request->keys(), ['user_id',$request->has('monitoring_points')? 'monitoring_points':'dams']);

                //except the monitoring points or dams  from valis_data array
                $valid_data = collect($valid_data)->only($keys)->toArray();

               // Get the notification setting by id and check if existing
               $data = find_and_update(NotificationsSetting::class,$id,$keys,$valid_data);

               $instances = $request->has('monitoring_points') ? $request->monitoring_points : $request->dams;

               $existingIds = collect($instances)->pluck('id')->toArray();

               $model = $request->has('monitoring_points') ? MonitoringPointsNotificationSettings::class : DamsNotificationSetting::class;

               $column = $request->has('monitoring_points') ? 'monitoring_point_id' : 'dam_id';

               $instances_setting = $model::where('notification_setting_id',$data->id)->select($column)->get()->pluck($column)->toArray();

               foreach($existingIds as $instance){

                    if(!in_array($instance,$instances_setting)){

                        $model::create([
                            $column => $instance,
                            'notification_setting_id' => $data->id
                         ]);
                    } 
               }

               
               foreach($instances_setting as $instance_setting){

                    if(!in_array($instance_setting,$existingIds)){

                        $model::where(['notification_setting_id'=>$data->id, $column => $instance_setting])->first()->delete();

                    }

                }

            }

            // Get the notification setting by id and check if existing
            $data = find_and_update(NotificationsSetting::class,$id,$keys,$valid_data);

            return response()->json([
                'data' => $data,
                'message' => __('notification-setting-editing-success')
            ],200);
        } catch (NotFoundResourceException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => __('notification-setting-editing-error')
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the notification setting by id and check if existing
        try {
            $data = getAndCheckModelById(NotificationsSetting::class, $id);

            return response()->json([
                'message' => __('notification-setting-delete-success')
            ],200);

        } catch (NotFoundResourceException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => __('notification-setting-delete-error')
            ], $e->getCode());
        }
    }
}
