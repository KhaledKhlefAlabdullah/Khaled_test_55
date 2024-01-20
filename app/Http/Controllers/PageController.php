<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource By user id.
     * Rule for [portal manager]
     *
     */
    public function index(string $user_id)
    {
        return User::findOrFail($user_id)->pages;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        $validData = $request->validated();

        Page::created($validData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return Page::findOrFail($page->id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        $validData = $request->validated();

        $page->update($validData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        Page::destroy($page->id);
    }
}
