<?php

namespace App\Http\Controllers;

use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\api_response;
use function App\Helpers\getIndustrialAreaID;
use function App\Helpers\stakeholder_id;

class ChatController extends Controller
{

    /**
     * Get the users in same industrial are
     */
    public function get_users_in_same_industrial_area(){
        try {

            $compaies = UserProfile::select('stakeholders.id as stakeholder_id','stakeholders.tenant_company_state as state', 'user_profiles.name', 'user_profiles.avatar_url')
                ->join('stakeholders', 'user_profiles.user_id', '=', 'stakeholders.user_id')
                ->join('users', 'stakeholders.user_id', 'users.id')
                ->where(['stakeholders.industrial_area_id' => getIndustrialAreaID()])
                ->whereNot('stakeholders.id', stakeholder_id())->get();

            return api_response(data: $compaies, message: 'companies-getting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'companies-getting-error', code: 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $industrial_area_id = getIndustrialAreaID();

            // Get a list of all chats
            $chatIds = DB::table('chat_members')
            ->where('user_id', Auth::id())
            ->pluck('chat_id');
            
            $chats = Chat::whereIn('chats.id', $chatIds)
            ->join('chat_members as cm', 'chats.id', '=', 'cm.chat_id')
            ->join('users as u', 'cm.user_id', '=', 'u.id')
            ->join('user_profiles as up', 'u.id', '=', 'up.user_id')
            ->select('chats.id as chat_id', 'u.id as user_id', 'up.name as user_name', 'up.avatar_url as avatar_url')
            ->where('u.id', '<>', Auth::id())
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
