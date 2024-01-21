<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsMessageRequest;
use App\Models\Contact_us_message;
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
        return Contact_us_message::all();
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
        $validData = $request->validated();

        Contact_us_message::created($validData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact_us_message $contactUsMessage)
    {
        return Contact_us_message::findOrFail($contactUsMessage->id);
    }


    /**
     * Update the specified resource in storage.
     *
     *  Only can update is_read
     */
    public function update(Request $request, Contact_us_message $contact_us_message)
    {
        $validData = $request->validated([
            'is_read' => ['boolean',]
        ]);

        $contact_us_message->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * TODO: : Rule for [portal manager]
     */
    public function destroy(Contact_us_message $contact_us_message)
    {
        Contact_us_message::destroy($contact_us_message->id);
    }
}
