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
        return ChatResource::collection(Chat::paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid_data = $request->validate([
            'chat_name' => ['required', 'string', 'max:255',],
        ]);

        $chat = Chat::create($valid_data);

        return new ChatResource($chat);

    }

    /**
     * Display the specified resource.
     *
     */
    public function show(string $id)
    {
        $chat = Chat::find($id);

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
        $valid_data = $request->validate([
            'chat_name' => ['sometimes', 'required', 'string', 'max:255',],
        ]);

        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        $chat->update($valid_data);

        return new ChatResource($chat);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        $chat->delete();

        return response()->noContent();

    }
}
