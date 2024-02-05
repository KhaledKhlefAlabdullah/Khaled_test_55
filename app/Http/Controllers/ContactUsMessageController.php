<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsMessageRequest;
use App\Http\Resources\ContactUsMessagesResource;
use App\Mail\PortalMails;
use App\Models\ContactUsMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactUsMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $messages = ContactUsMessage::paginate();

        return $messages->count() == 1
            ? new ContactUsMessagesResource($messages->first())
            : ContactUsMessagesResource::collection($messages);
    }


    /**
     * Store a newly created resource in storage.
     * Rule for [Tenant Company, Industrial Area Representative, Infrastructure Provider, Government Representative]
     *
     * @param ContactUsMessageRequest $request
     *
     */
    public function store(Request $request)
    {
        $valid_data = $request->validate([
            'subject' => 'required|string|',
            'message' => 'required|string|',
        ]);

        $user_id = User::where('stakeholder_type', 'Portal_manager')->first()->id;

        $user_auth = Auth::user();

        if ($user_auth){

            //
            if(Auth::user()->stakeholder_type == 'Portal_manager'){

                return response()->json([
                    'message' => __('your portal manager, you dont have to sent an contact us message to your self')
                ],404);

            }

            $user_email = $user_auth->email;

            ContactUsMessage::create([
                'user_id' => $user_id,
                'email' => $user_email,
                'subject' => $request->input('subject'),
                'message' => $request->input('message')
            ]);

        }else{

            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|string|email|max:255'
            ]);

            ContactUsMessage::create([
                'user_id' => $user_id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message')
            ]);

        }
        return response()->json([
            'message' => __('Successfully sending the contact us message')
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact_us_message = ContactUsMessage::find($id);

        if (!$contact_us_message) {
            return response()->json(['message' => 'Contact us message ID not found'], 404);
        }

        return new ContactUsMessagesResource($contact_us_message);
    }


    /**
     * Update the specified resource in storage.
     *
     *  Only can update is_read
     */
    public function update(Request $request, string $id)
    {

        $contact_us_message = ContactUsMessage::find($id);

        if (!$contact_us_message) {
            return response()->json(['message' => 'Contact us message ID not found'], 404);
        }

        $valid_data = $request->validate([
            'is_read' => ['boolean',]
        ]);

        $contact_us_message->update($valid_data);
        return new ContactUsMessagesResource($contact_us_message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * Rule for [portal manager]
     */
    public function destroy(string $id)
    {

        $contact_us_message = ContactUsMessage::find($id);

        if (!$contact_us_message) {
            return response()->json(['message' => 'Contact us message ID not found'], 404);
        }

        $contact_us_message->delete();

        return response()->json(['message' => 'Deleted Successfully']);

    }
}
