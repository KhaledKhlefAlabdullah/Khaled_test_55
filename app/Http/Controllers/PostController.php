<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\store_files;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all posts
        $posts = Post::paginate();

        return ($posts->count() == 1)
            ? new PostResource($posts->first())
            : PostResource::collection($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // Validate the request
        $valid_date = $request->validated();

        // Create the post
        $post = Post::create($valid_date);

        return new PostResource($post);
    }

    /**
     * Get all general news posts by category news
     */

    public function view_general_news()
    {

        try {

            // Get general news by get all posts with category news and posts is general news equal true
            $news = DB::table('categories')
                    ->join('posts','categories.id','=','posts.category_id')
                    ->select('posts.*')->where(['categories.type'=>'news','posts.is_general_news'=> true])->get();

            // Return json response with the result
            return response()->json([
                'news' => $news,
                'message' => __('Successfully getting news from database')
            ]);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ],500);

        }
    }

    /**
     * Add new general news
     */
    public function new_general_news(Request $request)
    {

        try {
            // validate the inputs
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:posts,slug|max:255',
                'body' => 'required|string',
                'media_file' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            // get category id where category is news
            $category_id = Category::where('type','news')->first()->id;

            // get auth user id as author
            $user_id = Auth::id();

            // get image from request
            $image = $request->media_file;

            // put path to store image
            $path = 'images/general_news_images';

            // coll store function to store the image
            $image_path = store_files($image,$path);

            // create new post as general news
            $new_general_news = Post::create([
                'user_id' => $user_id,
                'category_id' => $category_id,
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'body' => $request->input('body'),
                'media_url' => $image_path,
                'media_type' => 'image',
                'is_general_news' => true
            ]);

            // return response with created data
            return response()->json([
                'new_general_news' => $new_general_news,
                'message' => __('Successfully add new general news')
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Successfully adding new general news')
            ],500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get Post by id and check if exist
        try {
            $data = getAndCheckModelById(Post::class, $id);

            return new PostResource($data);

        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        // Get the post by id and check if exists
        try {
            $data = getAndCheckModelById(Post::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }
        // Validate the request
        $valid_date = $request->validated();

        // Update the post
        $data->update($valid_date);

        return new PostResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the post by id and check if exists
        try {
            $data = getAndCheckModelById(Post::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }

        // Delete the post
        $data->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
