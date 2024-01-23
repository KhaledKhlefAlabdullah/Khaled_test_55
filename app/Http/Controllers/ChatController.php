<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get a list of all chats
        $chats = Chat::latest()->paginate();

        return $chats->count() == 1
            ? new ChatResource($chats->first()) // return single chat
            : ChatResource::collection($chats); // return all chat resources
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $valid_data = $request->validate([
            'chat_name' => ['required', 'string', 'max:255',],
        ]);

        // Create the chat
        $chat = Chat::create($valid_data);

        // Return the chat
        return new ChatResource($chat);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(string $id)
    {
        // Get the chat
        $chat = Chat::find($id);

        // Check if the chat exists
        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        // When requesting only one chat, all messages and their users must be fetched
        // Assuming $chat is an instance of the Chat model
        return (new ChatResource($chat))->additional([
            'messages' => $chat->messages()
                ->latest()
                ->paginate(),
            'users' => $chat->users()->get()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $valid_data = $request->validate([
            'chat_name' => ['sometimes', 'required', 'string', 'max:255',],
        ]);

        // Get the chat By ID
        $chat = Chat::find($id);

        // Check if the chat exists
        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        // Update the chat
        $chat->update($valid_data);

        // Return the chat data
        return new ChatResource($chat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the chat By ID
        $chat = Chat::find($id);

        // Check if the chat exists
        if (!$chat) {
            return response()->json(['message' => 'Chat ID not found'], 404);
        }

        // Delete the chat
        $chat->delete();

        // Return message success
        return response()->json(['message' => 'Deleted successfully']);
    }
}
