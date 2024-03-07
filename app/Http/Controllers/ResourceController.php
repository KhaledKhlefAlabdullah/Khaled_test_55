<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

use function App\Helpers\api_response;
use function App\Helpers\stakeholder_id;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $resources = Resource::select('id','resource','quantity')->where('stakeholder_id',stakeholder_id())->get();

            return api_response(data:$resources,message:'resources-getting-success');
        }
        catch(Exception $e){

            return api_response(errors:[$e->getMessage()],message:'resources-getting-error',code:500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
