<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\api_response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index(string $chat_id)
    {
        try{
            // Get all messages from the authenticated user
        $messages = Message::where('chat_id',$chat_id)
            ->leftJoin('user_profiles as sender','sender.user_id','=','messages.sender_id')
            ->select('messages.message','messages.media_url','messages.is_read','messages.is_edit',
            'messages.is_starred','messages.created_at','sender.name as sender_name','sender.avatar_url as sender_profile')->get();

        return api_response(data:$messages,message:'messages-getting-success');
        
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'messages-getting-error',code:500);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        // Validate the request data
        $valid_data = $request->validated();

        // Create the message
        $message = Message::create($valid_data);

        // Return the newly created message
        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the message by message ID
        $message = Message::find($id);

        return (!$message) ?
            response()->json(['message' => 'Message not found'], 404) :
            new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, string $id)
    {
        // Get the message by message ID
        $message = Message::find($id);

        // Check if the message exists
        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }
        // Validate the message
        $valid_data = $request->validated();

        // Update the message
        $message->update($valid_data);

        // Return the updated message
        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the message by ID
        $message = Message::find($id);

        // Check if message exists
        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        // Delete the message
        $message->delete();

        // Return the deleted message
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
