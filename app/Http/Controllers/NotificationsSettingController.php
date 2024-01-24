<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSettingRequest;
use App\Http\Resources\Notification\NotificationSettingResource;
use App\Models\Notifications_setting;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

class NotificationsSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all notifications settings by auth user
        $data = Notifications_setting::where('user_id', auth()->user()->id)->get();

        return ($data->count() == 1)
            ? new NotificationSettingResource($data)
            : NotificationSettingResource::collection($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationSettingRequest $request)
    {
        // Check if validation
        $valid_data = $request->validated();

        // Create new notification setting
        $data = Notifications_setting::create($valid_data);

        return new NotificationSettingResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the notification setting by id and check if existing
        try {
            $data = getAndCheckModelById(Notifications_setting::class, $id);

            return new NotificationSettingResource($data);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationSettingRequest $request, string $id)
    {
        try {
            // Get the notification setting by id and check if existing
            $data = getAndCheckModelById(Notifications_setting::class, $id);

            $valid_data = $request->validated();

            $data->update($valid_data);

            return new NotificationSettingResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the notification setting by id and check if existing
        try {
            $data = getAndCheckModelById(Notifications_setting::class, $id);

            return new NotificationSettingResource($data);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
