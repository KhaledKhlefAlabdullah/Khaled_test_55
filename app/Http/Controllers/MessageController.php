<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * TODO: يجب تعديل هذه الدالة بحيث يسمح فقط لمالك المحادثة جلب الرسائل عن طريق معرف المحادثة
     */
    public function showMessagesByChatId(string $chat_id)
    {
        // Get all messages from the authenticated user
        $messages = Message::whereChatId($chat_id)->get();

        // Check is empty
        if (!$messages) {
            return response()->json(['message' => 'No messages found'], 404);
        }

        return $messages->count() == 1 ?
            new MessageResource($messages->first()) : // return only one message
            MessageResource::collection($messages); // return all messages
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $message_id)
    {
        $message = Message::find($message_id);

        return (!$message) ?
            response()->json(['message' => 'Message not found'], 404) :
            new MessageResource($message);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        return response()->json(['message' => 'Message deleted']);
    }
}
