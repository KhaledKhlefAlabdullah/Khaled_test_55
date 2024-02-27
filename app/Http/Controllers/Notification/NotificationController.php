<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notifications\Notification;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            // Get all notifications for the authenticated user
            $notifications = Auth::user()->notifications;

            // Extract only the "id" and "data" fields from each notification
            $notificationData = $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'sender_name' => $notification->data['sender_name'],
                    'sender_image' => $notification->data['sender_image'],
                    'message' => $notification->data['message']
                ];
            });

            // Return the response as JSON
            return response()->json([
                'data' => $notificationData,
                'message' => __('get-notifications-success')
            ], 200);

        }
        catch(Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('get-notifications-error')
            ],500);  
        }
    }


    /**
     * Store a newly created resource in storage.
     */
  

    /**
     * Display the specified resource.
     */

    /**
     * Marked the notification as read
     */
    public function marked_as_read(string $id)
    {
        try{

            $data = Auth::user()->notifications->where('id',$id);

            $data->markAsRead();

            return response()->json([
                'message' => __('marked-read-notifications-success')
            ],200);

        }
        catch(Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('marked-read-notifications-error')
            ],500);  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function     destroy(string $id)
    {
        // Get and check the notification
        try {

            $data = Auth::user()->notifications->where('id',$id)->first();

            $data->delete();

            return response()->json(['message' => 'Notification deleted successfully'],200);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
