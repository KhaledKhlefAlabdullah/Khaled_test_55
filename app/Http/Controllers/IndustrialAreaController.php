<?php

namespace App\Http\Controllers;

use App\Models\Industrial_area;
use Illuminate\Http\Request;

class IndustrialAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {

            $industrial_areas = Industrial_area::all();

            if($industrial_areas->isNotEmpty()){

                return response()->json([
                    'industrial_areas' => $industrial_areas,
                    'message' => __('Successfully request')
                ],201);

            }

            return response()->json([
                'message' => __('Successfully request but there industrial areas in database yeet')
            ],402);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message'=> __('Failed to get any thing')
            ],501);

        }
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
    public function show(Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industrial_area $industrial_area)
    {
        //
    }
}
