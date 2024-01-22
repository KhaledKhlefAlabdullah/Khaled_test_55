<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dam\StoreDamRequest;
use App\Http\Requests\Dam\UpdateDamRequest;
use App\Http\Resources\DamResource;
use App\Models\Dam;

class DamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DamResource::collection(Dam::paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDamRequest $request)
    {
        $valid_data = $request->validated();
        $dam = Dam::create($valid_data);
        return new DamResource($dam);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dam $dam)
    {
        return new DamResource($dam);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDamRequest $request, Dam $dam)
    {
        $valid_data = $request->validated();

        $dam->update($valid_data);

        return new DamResource($dam);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dam $dam)
    {
        $dam->delete();

        return response()->json(null, 204);
    }
}
