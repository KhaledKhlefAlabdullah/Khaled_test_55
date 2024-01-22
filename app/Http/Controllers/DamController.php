<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dam\StoreDamRequest;
use App\Http\Resources\DamResource;
use App\Models\Dam;
use Exception;
use Illuminate\Http\Request;

class DamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return DamResource::collection(Dam::paginate());
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDamRequest $request)
    {
        $valid_data = $request->validated();

        try {

            $valid_data['user_id'] = \Auth::id();

            $dam = Dam::create($valid_data);

            return new DamResource($dam);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Dam $dam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dam $dam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dam $dam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dam $dam)
    {
        //
    }
}
