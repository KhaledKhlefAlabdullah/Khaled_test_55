<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notifications\Notification;
use App\Models\User;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all Notifications by relationship user and notifications
        $data = User::with('notifications')->latest()->paginate();

        return ($data->count() == 1)
            ? new NotificationResource($data->first())
            : NotificationResource::collection($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        $notification = Notification::create($validated);

        return new NotificationResource($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get and check the notification
        try {
            $data = getAndCheckModelById(Notification::class, $id);

            return new NotificationResource($data);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, string $id)
    {
        // Get and check the notification
        try {
            $data = getAndCheckModelById(Notification::class, $id);

            $validated = $request->validated();

            $data->update($validated);

            return new NotificationResource($data);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get and check the notification
        try {
            $data = getAndCheckModelById(Notification::class, $id);

            $data->delete();

            return response()->json(['message' => 'Notification deleted successfully']);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
