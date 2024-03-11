<?php

namespace App\Http\Controllers;

use App\Http\Requests\Resource\ResourceRequest;
use App\Models\Resource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\stakeholder_id;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $resources = Resource::select('id','resource','quantity','notes')->where('stakeholder_id',stakeholder_id())->get();

            return api_response(data:$resources,message:'resources-getting-success');
        }
        catch(Exception $e){

            return api_response(errors:[$e->getMessage()],message:'resources-getting-error',code:500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceRequest $request)
    {
        try{

            $validatedData = $request->validated();

            Resource::create($validatedData);

            return api_response(message:'resource-creatting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resource-creatting-error',code:500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResourceRequest $request, string $id)
    {
        try{

            $validatedData = $request->validated();

            $resource = getAndCheckModelById(Resource::class,$id);

            $resource->update($validatedData);

            return api_response(message:'resource-updatting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resource-updatting-error',code:500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $resource = getAndCheckModelById(Resource::class,$id);

            $resource->delete();

            return api_response(message:'resource-deleting-success');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'resource-deleting-error',code:500);
        }
    }
}
