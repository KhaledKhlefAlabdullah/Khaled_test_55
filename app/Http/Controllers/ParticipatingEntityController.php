<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipatingEntityRequest;
use App\Models\ParticipatingEntity;

class ParticipatingEntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ParticipatingEntity::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * TODO: : Rule for [portal manager]
     */
    public function store(ParticipatingEntityRequest $request)
    {
        $validData = $request->validated();

        ParticipatingEntity::create($validData);
    }

    /**
     * Display the specified resource.
     *
     * Rule for [portal manager]
     */
    public function show(ParticipatingEntity $pe)
    {
        return ParticipatingEntity::findOrFail($pe->id);
    }



    /**
     * Update the specified resource in storage.
     *
     * Rule for [portal manager]
     */
    public function update(ParticipatingEntityRequest $request, ParticipatingEntity $pe)
    {
        $validData = $request->validated();

        $pe->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * Rule for [portal manager]
     */
    public function destroy(ParticipatingEntity $pe)
    {
        ParticipatingEntity::destroy($pe->id);
    }
}
