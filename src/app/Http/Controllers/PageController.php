<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\edit_file;
use function App\Helpers\edit_page_details;
use function App\Helpers\get_instances_with_value;
use function App\Helpers\getIdByName;
use function App\Helpers\store_files;

class PageController extends Controller
{
    /**
     * Display a listing of the resource By user id.
     * Rule for [portal manager]
     *
     */
    public function index()
    {
        // Get all pages by auth user id
        $pages = Page::where('user_id', Auth::id())->paginate();


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


    /**
     * Get contact us page
     */
    public function contact_us_details()
    {
        try {

            $contact_us = Page::where('type', 'Contact-Us')->select('pages.id', 'pages.phone_number',
                'pages.location', 'pages.start_time', 'pages.end_time')->first();

            return response()->json([
                'data' => $contact_us,
                'message' => __('Successfully getting contact us details')
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in getting the contact us details')
            ], 500);

        }
    }

    /**
     * Fill contact us details
     */
    public function edite_contact_us_details(Request $request)
    {
        // validate the inputs
        $request->validate([
            'phone_number' => 'required',
            'location' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        return edit_page_details($request, 'Contact-Us');
    }

    /**
     * Get about page details
     */
    public function about_us_page_details()
    {
        try {

            // get the about us details
            $about_us = Page::where('type', 'About')->with('posts')->first();

            // return the page id and title and return the posts belong to about us page
            if ($about_us) {
                $responseData = [
                    'page_id' => $about_us->id,
                    'page_title' => $about_us->title,
                    'posts' => $about_us->posts->map(function ($post) {
                        return [
                            'post_id' => $post->id,
                            'post_title' => $post->title,
                            'post_body' => $post->body,
                            'post_image' => $post->media_url
                        ];
                    })
                ];
            }

            return response()->json([
                'data' => $responseData,
                'message' => __('successfully getting about us page details')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in getting  the about us details')
            ], 500);
        }
    }

    /**
     * Edite about us page details
     */
    public function edite_about_us_post_details(Request $request, string $id)
    {
        try {

            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string|min:10',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            $post = Post::find($id);

            $file = $request->image;

            $path = 'images/about_us_images';

            if (!$post) {

                $file_path = store_files($file, $path);

                $user_id = Auth::id();

                $page_id = get_instances_with_value(Page::class, 'About')->id;

                $category_id = getIdByName(Category::class, 'About')->id;

                $post = Post::create([
                    'user_id' => $user_id,
                    'page_id' => $page_id,
                    'category_id' => $category_id,
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'media_url' => $file_path,
                    'media_type' => 'image'
                ]);

            } else {

                $image_path = edit_file(
                    $post->media_url,
                    $file,
                    $path
                );

                $post->update([
                    'body' => $request->input('body'),
                    'media_url' => $image_path,
                    'media_type' => 'image'
                ]);

            }

            return response()->json([
                'data' => $post,
                'message' => __('Successfully editing the data')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in editing the data')
            ], 500);
        }
    }
}
