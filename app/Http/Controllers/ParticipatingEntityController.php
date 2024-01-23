<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipatingEntityRequest;
use App\Models\Participating_entity;

class ParticipatingEntityController extends Controller
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
     *
     * Rule for [portal manager]
     */
    public function store(ParticipatingEntityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * Rule for [portal manager]
     */
    public function show(Participating_entity $pe)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * Rule for [portal manager]
     */
    public function update(ParticipatingEntityRequest $request, Participating_entity $pe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * Rule for [portal manager]
     */
    public function destroy(Participating_entity $pe)
    {
        //
    }
}
