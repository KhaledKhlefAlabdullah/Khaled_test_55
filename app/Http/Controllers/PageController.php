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
            return PageResource::collection(Page::paginate());

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
    public function show(Page $page)
    {

        return (new PageResource($page))->load('posts');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {

        $valid_data = $request->validated();
            $page->update($valid_data);

            return new PageResource($page);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {

        $page->delete();

        return response()->noContent();

    }
}
