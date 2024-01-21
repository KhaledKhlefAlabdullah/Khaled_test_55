<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsMessageRequest;
use App\Http\Resources\ContactUsMessagesResource;
use App\Models\Contact_us_message;
use Exception;
use Illuminate\Http\Request;

class ContactUsMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * TODO: Rule for [portal manager]
     *
     */
    public function index()
    {
        try {
            return ContactUsMessagesResource::collection(Contact_us_message::paginate());
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     * TODO: Rule for [Tenant Company, Industrial Area Representative, Infrastructure Provider, Government Representative]
     *
     * @param ContactUsMessageRequest $request
     *
     */
    public function store(ContactUsMessageRequest $request)
    {
        $valid_data = $request->validated();
        try {
            $contact_us_message = Contact_us_message::create($valid_data);

            return new ContactUsMessagesResource($contact_us_message);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact_us_message $contact_us_message)
    {
        try {
            return new ContactUsMessagesResource($contact_us_message);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     *  Only can update is_read
     */
    public function update(Request $request, Contact_us_message $contact_us_message)
    {
        $valid_data = $request->validate([
            'is_read' => ['boolean',]
        ]);

        try {
            $contact_us_message->update($valid_data);
            return new ContactUsMessagesResource($contact_us_message);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * TODO: : Rule for [portal manager]
     */
    public function destroy(Contact_us_message $contact_us_message)
    {
        try {
            $contact_us_message->delete();

            return response()->noContent(); // HTTP 204 No Content
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the resource.',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
