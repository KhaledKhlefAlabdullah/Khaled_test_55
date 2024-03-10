<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Exception;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getMediaType;
use function App\Helpers\search;
use function App\Helpers\store_files;

class MessageController extends Controller
{


    /**
     * Get messages by conditions
     */
    public function get_messages_by_conditions(array $conditions)
    {
        try {
            // Get all messages from the authenticated user
            $messages = Message::where($conditions)
                ->leftJoin('user_profiles as sender', 'sender.user_id', '=', 'messages.sender_id')
                ->select('messages.id', 'messages.message', 'messages.media_url', 'messages.is_read', 'messages.is_edit',
                    'messages.is_starred', 'messages.created_at', 'sender.name as sender_name', 'sender.avatar_url as sender_profile')->get();

            return api_response(data: $messages, message: 'messages-getting-success');

        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'messages-getting-error', code: 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(string $chat_id)
    {
        return $this->get_messages_by_conditions(['chat_id' => $chat_id]);
    }

    /**
     * Display list of starred messages
     */
    public function get_starred_messages(string $chat_id)
    {
        return $this->get_messages_by_conditions(['chat_id' => $chat_id, 'is_starred' => true]);
    }

    /**
     * Search for message in chat
     */
    public function search_message(string $chat_id, string $query)
    {
        return search(Message::class, ['chat_id' => $chat_id], $query);
    }

    /**
     * Set message as starred
     */
    public function set_message_starred(string $message_id)
    {
        try {

            $message = getAndCheckModelById(Message::class, $message_id);

            $message->update([
                'is_starred' => !$message->is_starred
            ]);

            return api_response(message: 'message-set-starred-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'message-set-starred-error', code: 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        try {
            // Validate the request data
            $request->validated();

            $media_ur = null;

            $file_type ='text';

            if($request->has('media')){

                $file = $request->media;

                $file_type = getMediaType($file);

                $path = 'messages/' . $file_type;

                $media_url = store_files($file, $path);

            }

            // Create the message
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->input('receiver_id'),
                'chat_id' => $request->input('chat_id'),
                'message' => $request->input('message'),
                'media_url' => $media_ur,
                'message_type' => $file_type,
            ]);

            return api_response(message: 'message-creating-success');

        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'message-creatting-error', code: 500);
        }
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
    public function update(MessageRequest $request, string $id)
    {
        try{
             // Get the message by message ID
            $message = getAndCheckModelById(Message::class,$id);

            // Validate the message
            $request->validated();

            // Update the message
            $message->update([
                'message' => $request->input('message')
            ]);

            return api_response(message:'message-editting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'message-editting-error',code:500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            // Get the message by ID
            $message = getAndCheckModelById(Message::class,$id);

            if($message->media_url){
                unlink(public_path($message->media_url));
            }
            // Delete the message
            $message->delete();

            // Return the deleted message
            return api_response(message:'message-delete-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'message-delete-error',code:500);
        }

    }


    /**
     *
     */
    public function send_message(Request $request)
    {
        $data = $request->only(['message', 'sender_id']);
        // send event for receiver user but not to current user
        broadcast(new ChatEvent($data))->toOthers(); //

        return api_response(
            message: __('send-message-successfully')
        );
    }
















}
