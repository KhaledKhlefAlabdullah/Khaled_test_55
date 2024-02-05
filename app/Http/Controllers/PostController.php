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
use function App\Helpers\edit_file;
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

    /**
     * Get all general news posts by category news
     */

    public function view_general_news()
    {

        try {

            // Get general news by get all posts with category news and posts is general news equal true
            $news = DB::table('categories')
                ->join('posts','categories.id','=','posts.category_id')
                ->select('posts.*')->where(['categories.name'=>'news','posts.is_general_news'=> true])->get();

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
            $category_id = Category::where('name','news')->first()->id;

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
                'message' => __('There an error in server side')
            ],500);

        }
    }

    /**
     * Edite general news
     */
    public function edite_general_news(Request $request)
    {

        try {
            // validate the inputs
            $request->validate([
                'general_news_id'=> 'required|string|exists:posts,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:posts,slug|max:255',
                'body' => 'required|string',
                'media_file' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            // get general news id from request
            $general_news_id = $request->input('general_news_id');

            // get the general news will be editing
            $general_news = Post::findOrFail($general_news_id);

            // get image from request
            $new_image = $request->media_file;

            // put path to store image
            $path = 'images/general_news_images';

            // get old file path
            $old_file_path = $general_news->media_url;

            // coll store function to store the image
            $image_path = edit_file($old_file_path, $new_image, $path);

            // create new post as general news
            $general_news->update([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'body' => $request->input('body'),
                'media_url' => $image_path,
                'media_type' => 'image'
            ]);

            // return response with created data
            return response()->json([
                'new_general_news' => $general_news,
                'message' => __('Successfully editing general news')
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There an error in server side')
            ],500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_general_news(Request $request)
    {
        // Get the post by id and check if exists
        try {

            $request->validate([
                'id' => 'required|string|exists:posts,id'
            ]);

            // get the id from request
            $id = $request->input('id');

            // get the news object
            $data = getAndCheckModelById(Post::class, $id);

            // store the is general state to check on it
            $is_general = $data->is_general_news;

            // general message
            $message = 'general news deleted successfully';

            // Delete the post if it general news else put another message
            $is_general? $data->delete() : $message = 'is not general news you can\'t delete it';

            return response()->json([
                'message' => __($message)
            ],200);

        } catch (NotFoundResourceException $e) {

            return response()->json([__($e->getMessage())], $e->getCode());

        }
    }

    /**
     * Get project description
     */
    public function view_project_description()
    {
        try {

            $description = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->select('posts.id', 'posts.body', 'posts.media_url')->where('categories.name', '=', 'Project Description')->first();

            return response()->json([
                'data' => $description,
                'message' => __('Successfully get project description')
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('filed to get project description, there an problem')
            ],200);

        }
    }

    /**
     * Add project description
     */
    public function edite_project_description(Request $request, string $id)
    {
        try{

            // validate the input data
            $request->validate([
                'body' => 'required|string|min:10',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            // get the posts (project description) with category id
            $posts = Post::find($id);

            // get image from request
            $image = $request->image;

            // put path to store image
            $path = 'images/project_description_images';

            // coll store function to store the image
            $image_path = store_files($image, $path);

            // if their no post with category id create one or update the exists on
            if(empty($posts)){

                // get auth user id
                $user_id = Auth::id();

                // get the project description category
                $category_id = Category::where('name', 'Project description')->first()->id;

                $posts = Post::create([
                    "user_id" => $user_id,
                    "category_id" => $category_id,
                    "body" => $request->input('body'),
                    "media_url" => $image_path

                ]);

                $message = 'Successfully creating project description';

            }
            else{

                $posts->update([
                    "body" => $request->input('body'),
                    "media_url" => $image_path
                ]);

                $message = 'Successfully editing project description';

            }

            return response()->json([
                'project_description' => $posts,
                'message' => __($message)
            ]);

        }
        catch (\Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ],500);
        }
    }

}
