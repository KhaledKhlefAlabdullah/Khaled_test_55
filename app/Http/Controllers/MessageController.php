<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;


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
    public function show(string $message_id)
    {
        // Get the message by message ID
        $message = Message::find($message_id);

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
