<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource By user id.
     * Rule for [portal manager]
     *
     */
    public function index()
    {
        try {
            $data = Page::all();

            return PageResource::collection($data);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        try {
            $validData = $request->validated();
//        dd($validData);
            Page::create($validData);


            return PageResource::make($validData);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        try {

            return PageResource::make($page);
//        return Page::findOrFail($page->id);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        try {

            $validData = $request->validated();
            $page->update($validData);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        Page::destroy($page->id);
    }
}
