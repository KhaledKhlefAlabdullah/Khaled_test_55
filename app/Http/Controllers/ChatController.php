<?php

namespace App\Http\Controllers;

use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\api_response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $industrial_area_id = Auth::user()->stakeholder->industrial_area_id;

            $chats = User::select('user_profiles.name as user_name', 'user_profiles.avatar_URL as user_avatar')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->join('chat_members', 'users.id', '=', 'chat_members.user_id')
                ->join('chats', 'chat_members.chat_id', '=', 'chats.id')
                ->join('stakeholders', 'user_profiles.user_id', '=', 'stakeholders.user_id')
                ->where('users.id', '<>', Auth::id())
                ->where('stakeholders.industrial_area_id', $industrial_area_id)
                ->get();
     
            return api_response(data:$chats,message:'chats-getting-success');

        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'chats-getting-error',code:500);
        }
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
