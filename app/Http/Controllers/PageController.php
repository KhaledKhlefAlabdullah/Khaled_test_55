<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            return PageResource::collection(Page::paginate());

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     * TODO Fix this function
     * Only "Portal Manager" can be store a page.
     */
    public function store(StorePageRequest $request)
    {
//        $request->user_id = \Auth::id();
//        $valid_data = $request->validated();
        try {

            $valid_data = $request->validated();
            $page = Auth::user()->pages()->create($valid_data);

//            $page = Page::create($valid_data);
//            $page = Auth::User()->pages()->create($valid_data);

            return new PageResource($page);

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
            return (new PageResource($page))->load('posts');

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $valid_data = $request->validated();
            $page->update($valid_data);

            return new PageResource($page);
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
        try {
            $page->delete();

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
