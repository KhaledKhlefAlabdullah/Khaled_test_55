<?php

namespace App\Http\Controllers;

use App\Models\ResourceRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

use function App\Helpers\api_response;
use function App\Helpers\stakeholder_id;

class ResourceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validated();

            ResourceRequest::create([
                'sender_stakeholder_id' => stakeholder_id(),
                'receiver_stakeholder_id' => $request->input('receiver_stakeholder_id'),
                'resource_id' => $request->input('resource_id'),
                'quantity' => $request->input('quantity')
            ]);

            return api_response(message:'resource-request-creatting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resource-request-creatting-error',code:500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ResourceRequest $resourceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResourceRequest $resourceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResourceRequest $resourceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResourceRequest $resourceRequest)
    {
        //
    }
}
