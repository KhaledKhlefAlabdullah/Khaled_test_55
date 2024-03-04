<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementsRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\Posts\GeneralNewsRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\edit_file;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\getMediaType;
use function App\Helpers\search;
use function App\Helpers\send_notifications;
use function App\Helpers\store_files;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($condations, $columns)
    {
        $posts = Post::where($condations)->select($columns)->get();

        return $posts;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $category_id)
    {
        try {

            $request->validated();

            $file_type = null;

            if($request->media){

                $file = $request->media;

                $file_type = getMediaType($file);

                $path = $file_type.'s/articles';

                $file_path = store_files($file,$path);

            }

            Post::create([
                'user_id' => Auth::id(),
                'category_id' => $category_id,
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'media_url' => $file_path,
                'media_type' => $file_type,
                'is_priority' => $request->input('is_priority'),
                'priority_count' =>  $request->input('priority_count'),
                'is_general_news' => $request->input('is_general_news') ? $request->input('is_general_news') : false,
                'is_publish' =>  $request->input('is_publish') ? $request->input('is_publish'): true
            ]);

            return api_response(message:'data-getting-success');

        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'data-adding-success',code:500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get Post by id and check if exist
        try {

            $data = getAndCheckModelById(Post::class, $id)->select('title', 'body', 'media_url')->first();

            return api_response(data: $data, message: 'data-getting-success');

        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-getting-error', code: 500);
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
                ->join('posts', 'categories.id', '=', 'posts.category_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->select('posts.id', 'user_profiles.name', 'categories.name', 'posts.title',
                    'posts.body', 'posts.media_url as image')
                ->where(['categories.name' => 'news', 'posts.is_general_news' => true])
                ->whereNull('posts.deleted_at')
                ->get();

            // Return json response with the result

            return api_response(data: $news, message: 'general-news-getting-success');
        } catch (Exception $e) {

            return api_response(errors: $e->getMessage(), message: 'general-news-getting-error', code: 500);
        }
    }

    /**
     * Add new general news
     */
    public function new_general_news(GeneralNewsRequest $request)
    {

        try {

            $request->validate([
                'image' => 'required'
            ]);

            // get category id where category is news
            $category_id = Category::where('name', 'news')->first()->id;

            // get auth user id as author
            $user_id = Auth::id();

            // get image from request
            $image = $request->image;

            // put path to store image
            $path = '/images/general_news_images';

            // coll store function to store the image
            $image_path = store_files($image, $path);

            // create new post as general news
            Post::create([
                'user_id' => $user_id,
                'category_id' => $category_id,
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'media_url' => $image_path,
                'media_type' => 'image',
                'is_general_news' => true
            ]);

            // Send notification after add new general news
            send_notifications(User::all(), ['database', 'mail'], config('golbals.new-generalNews'));

            // return response with created data
            return response()->json([
                'message' => __('general-news-create-success')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('general-news-create-error')
            ], 500);

        }
    }

    /**
     * edit general news
     */
    public function edit_general_news(GeneralNewsRequest $request, string $id)
    {
        try {

            // get the general news will be editing
            $general_news = Post::findOrFail($id);

            if (is_null($request->image)) {

                $image_path = $general_news->media_url;

            } else {
                // get image from request
                $new_image = $request->image;

                // put path to store image
                $path = '/images/general_news_images';

                // get old file path
                $old_file_path = $general_news->media_url;

                // coll store function to store the image
                $image_path = edit_file($old_file_path, $new_image, $path);
            }

            // create new post as general news
            $general_news->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'media_url' => $image_path,
                'media_type' => 'image'
            ]);

            // return response with created data
            return response()->json([
                'new_general_news' => $general_news,

                'message' => __('general-news-edit-success')
            ], 200);


        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('general-news-edit-error')
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_general_news(string $id)
    {
        // Get the post by id and check if exists
        try {


            // get the news object
            $data = getAndCheckModelById(Post::class, $id);

            // store the is general state to check on it
            $is_general = $data->is_general_news;

            // general message
            $message = 'general-news-delete-success';

            // Delete the post if it general news else put another message
            $is_general ? $data->delete() : $message = 'not-general-news-delete-error';

            return response()->json([
                'message' => __($message)
            ], 200);

        } catch (NotFoundResourceException $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('general-news-delete-error')
            ], $e->getCode());

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


            return api_response(data: $description, message: 'Successfully get project description');
        } catch (\Exception $e) {

            return api_response(errors: $e->getMessage(), message: 'filed to get project description, there an problem', code: 500);
        }
    }

    /**
     * Add project description
     */
    public function edit_project_description(Request $request, string $id)
    {
        try {

            // validate the input data
            $request->validate([
                'body' => 'required|string|min:10',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            // get the posts (project description) with category id
            $post = Post::find($id);


            // if their no post with category id create one or update the exists on
            if (empty($post)) {

                // get image from request
                $image = $request->image;

                // put path to store image
                $path = '/images/project_description_images';

                // coll store function to store the image
                $image_path = store_files($image, $path);

                // get auth user id
                $user_id = Auth::id();

                // get the project description category
                $category_id = Category::where('name', 'Project description')->first()->id;

                Post::create([
                    "user_id" => $user_id,
                    "category_id" => $category_id,
                    "title" => now(),
                    "body" => $request->input('body'),
                    "media_url" => $image_path

                ]);

                $message = 'Successfully creating project description';

            } else {

                // get image from request
                $image = $request->image;

                // put path to store image
                $path = '/images/project_description_images';

                // coll store function to store the image
                $image_path = edit_file($post->media_url, $image, $path);


                $post->update([
                    "body" => $request->input('body'),
                    "media_url" => $image_path
                ]);

                $message = 'Successfully editing project description';

            }

            return response()->json([
                'message' => __($message)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ], 500);
        }
    }

    // For Articles
    // View list of articles
    public function view_list_of_articles()
    {
        try {

            $articles = $this->index(['page_id' => getIdByName(Page::class, 'Article', 'title')], ['id', 'title', 'created_at as date']);

            return api_response(data: $articles, message: 'articles-getting-success');

        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'articles-getting-error', code: 500);
        }
    }

    // Get the article details
    public function view_article(string $id)
    {
        return $this->show($id);
    }

    // Search for articale
    public function search_article(string $query)
    {
        return search(Post::class, ['category_id' => getIdByName(Category::class, 'Article')], $query);
    }

    // Add article
    public function add_article(PostRequest $request)
    {

        return $this->store($request, getIdByName(Category::class,'Articles'));

    }

    // For News
    // View the News: News - date of publication -news source		
    public function view_news(){
        return $this->index(['category_id' => getIdByName(Category::class,'News')],['id', 'title', 'body', 'media_url', 'is_priority', 'created_at']);
    }			
}
