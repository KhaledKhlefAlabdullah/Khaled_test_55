<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsMessageRequest;
use App\Http\Resources\ContactUsMessagesResource;
use App\Models\ContactUsMessage;
use Illuminate\Http\Request;

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
    public function store(ContactUsMessageRequest $request)
    {
        $valid_data = $request->validated();

        $contact_us_message = ContactUsMessage::create($valid_data);

        return new ContactUsMessagesResource($contact_us_message);
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
