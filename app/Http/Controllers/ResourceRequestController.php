<?php

namespace App\Http\Controllers;

use App\Http\Requests\timelines\ResourceRequestsRequest;
use App\Models\ResourceRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\stakeholder_id;
use function Laravel\Prompts\error;

class ResourceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $resources_requests = ResourceRequest::where('resource_requests.receiver_stakeholder_id',stakeholder_id())
            ->select('resource_requests.id as request_id','up.user_id','sk.id as stakeholder_id','up.name','r.resource','resource_requests.request_state','r.quantity as resource_quantity','resource_requests.quantity as required_quantity')
            ->join('stakeholders as sk','resource_requests.sender_stakeholder_id','=','sk.id')
            ->join('user_profiles as up','sk.user_id','=','up.user_id')
            ->join('resources as r','resource_requests.resource_id','=','r.id')
            ->get();

            return api_response(data:$resources_requests,message:'resources-requests-getting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resources-requests-getting-error',code:500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceRequestsRequest $request)
    {
        try{

            $validated_data = $request->validated();

            ResourceRequest::create($validated_data);

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
    public function accept_reject(Request $request, string $id)
    {
        try{

            $request->validate([
                'state' =>'boolean'
            ]);

            $request = getAndCheckModelById(ResourceRequest::class,$id);

            $request->update([
                'request_state' => $request->state ? 'accept' : 'reject'
            ]);

            return api_response(message:'resource-request-change-state-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resource-request-change-state-error',code:500);
        }
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
