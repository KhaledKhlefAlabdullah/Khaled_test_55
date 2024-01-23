<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource By user id.
     * Rule for [portal manager]
     *
     */
    public function index()
    {
        // Get all pages paginated
        $pages = Page::paginate();

        // If there is only one page, return it
        return $pages->count() == 1 ?
            new PageResource($pages->first()) :
            PageResource::collection($pages); // Otherwise, return the List of pages
    }


    /**
     * Store a newly created resource in storage.
     * Fix this function
     * Only "Portal Manager" can be store a page.
     */
    public function store(StorePageRequest $request)
    {

        $valid_data = $request->validated();

        $page = Page::create($valid_data);

        return new PageResource($page);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'This page ID not found'], 404);
        }
        return (new PageResource($page))->load('posts');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, string $id)
    {

        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'This page ID not found'], 404);
        }

        $valid_data = $request->validated();
        $page->update($valid_data);

        return new PageResource($page);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'This page ID not found'], 404);
        }

        $page->delete();

        return response()->json(['message' => 'Page is deleted Successfully']);

    }
}
