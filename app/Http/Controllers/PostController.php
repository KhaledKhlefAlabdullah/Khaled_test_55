<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\Posts\GeneralNewsRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
<<<<<<< HEAD
use App\Notifications\PostsNotifications;
=======
>>>>>>> khaled
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
=======
use Symfony\Component\Translation\Exception\NotFoundResourceException;

>>>>>>> khaled
use function App\Helpers\api_response;
use function App\Helpers\edit_file;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\search;
use function App\Helpers\send_notifications;
use function App\Helpers\store_files;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($condations,$columns)
    {
        $posts = Post::where($condations)->with('category')->select($columns)->get();

        return $posts;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try{

            Post::create([
                'page_id' => ['sometimes', 'required', 'uuid', 'exists:pages,id'],
                'category_id' => ['sometimes', 'required', 'uuid', 'exists:categories,id'],
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'body' => ['sometimes', 'required', 'string'],
                'media_url' => ['nullable', 'url'],
                'media_type' => ['nullable', 'string', 'in:image,video,file'],
            ]);

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

            $data = getAndCheckModelById(Post::class, $id)->select('title','body','media_url')->first();

            return api_response(data:$data,message:'data-getting-success');

        } catch (NotFoundResourceException $e) {
            return api_response(errors:[$e->getMessage()],message:'data-getting-error',code:500);
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
<<<<<<< HEAD
            $news = DB::table('categories')
                ->join('posts', 'categories.id', '=', 'posts.category_id')
=======
            $news = 
            DB::table('categories')
                ->join('posts','categories.id','=','posts.category_id')
>>>>>>> khaled
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->select('posts.id', 'user_profiles.name', 'categories.name', 'posts.title',
                    'posts.body', 'posts.media_url as image')
                ->where(['categories.name' => 'news', 'posts.is_general_news' => true])
                ->whereNull('posts.deleted_at')
                ->get();

            // Return json response with the result
<<<<<<< HEAD
            return response()->json([
                'news' => $news,
                'message' => __('general-news-getting-success')
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('general-news-getting-error')
            ], 500);
=======
            return api_response(data:$news,message:'general-news-getting-success');
        }
        catch (Exception $e){
>>>>>>> khaled

            return api_response(errors:$e->getMessage(),message:'general-news-getting-error',code: 500);
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

<<<<<<< HEAD
            return response()->json([
                'data' => $description,
                'message' => __('Successfully get project description')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('filed to get project description, there an problem')
            ], 200);
=======
            return api_response(data:$description,message:'Successfully get project description');
        }
        catch (\Exception $e){

            return api_response(errors:$e->getMessage(),message:'filed to get project description, there an problem',code:500);
>>>>>>> khaled

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


    /**
     * View the list of announcements based on the specified category ID.
     *
     * This endpoint retrieves a list of announcements filtered by the specified category ID.
     * The returned data includes announcement ID, user ID, title, body, publication status, and media URL.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view_list_of_announcements(): \Illuminate\Http\JsonResponse
    {

        try {
            // Get list of announcements
            // this id 048e9200-e29b-41d4-a716-446655440000 for announcements category
            $data = Post::where('category_id', '=', '048e9200-e29b-41d4-a716-446655440000')
                ->select('id', 'user_id', 'title', 'body', 'is_publish', 'media_url')->get();

            // Check if any announcements were found
            if ($data->isEmpty()) {
                return api_response(message: __('announcements-list-is-empty'));
            }

            // Return response helper
            return api_response(data: $data,
                message: __('view-list-of-announcements-successfully'));

        } catch (Exception $e) {
            // Log the error
            Log::error($e->getMessage());

            // Return error response
            return api_response(
                message: $e->getMessage(),
                code: $e->getCode(),
                errors: ['error on list of announcements']);
        }
    }


    /**
     * View the list of announcements created by the authenticated user.
     *
     * This endpoint retrieves a list of announcements belonging to the authenticated user.
     * The announcements are filtered by the specified category ID and include details such as
     * announcement ID, user ID, title, body, publication status, and media URL.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view_list_of_my_announcements(): \Illuminate\Http\JsonResponse
    {

        try {
            // Get list of user announcements
            // this id 048e9200-e29b-41d4-a716-446655440000 for announcements category
            // user_id is created announcements
            $data = Post::where('category_id', '=', '048e9200-e29b-41d4-a716-446655440000')
                ->where('user_id', '=', Auth::id())
                ->select(['id', 'user_id', 'title', 'body', 'is_publish', 'media_url'])->get();

            // Check if any announcements were found
            if ($data->isEmpty()) {
                return api_response(message: __('announcements-list-is-empty'));
            }

            // Return response helper
            return api_response(data: $data,
                message: __('view-list-of-my-announcements-successfully'));

        } catch (Exception $e) {
            // Log the error
            Log::error($e->getMessage());

            // Return error response
            return api_response(
                message: $e->getMessage(),
                code: 404,
                errors: ['error on user list of announcements']);
        }
    }


    /**
     * Publish an announcement based on the provided request data.
     *
     * This method expects 'id' and 'is_publish' in the request.
     * It performs validation and publishes the announcement if everything is valid.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish_an_announcements(Request $request)
    {
        try {
            // Get 'id' and 'is_publish' from the request
            $id = $request->input('id');
            $isPublish = $request->input('is_publish') ?? true;

            // Validate data as needed (you may customize this validation)
            $validated = $request->validate([
                'id' => ['required', 'uuid'],
                'is_publish' => ['sometimes', 'boolean'],
            ]);

            // Check if validation passes or fails
            if (!$validated) {
                return api_response(message: __('Validation failed'), code: 400);
            }


            // Update the announcement with the provided 'is_publish' status
            $announcement = Post::find($id);

            if (!$announcement) {
                return api_response(message: __('Announcement not found'), code: 404);
            }

            $announcement->update(['is_publish' => $isPublish]);

            // Return success response
            return api_response(message: __('Announcement published successfully'));

        } catch (\Exception $e) {
            // Log the error
            Log::error($e->getMessage());

            // Return error response
            return api_response(
                message: $e->getMessage(),
                code: $e->getCode() ?: 500,
                errors: ['error publishing announcement']
            );


        }
    }


    /*
     * Edit my  Announcement
     *
     */
    public function edit_announcements(PostRequest $request, string $id)
    {
        try {
            // validate data request
            $data_valid = $request->validated();

            // get data from id
            $data = getAndCheckModelById(Post::class, $id);

            // update
        } catch (NotFoundResourceException $e) {
            return api_response(
                message: $e->getMessage(),
                code: $e->getCode() ?? 500, errors: ['not found resource']
            );
        }
    }

    // For Articles
    // View list of articles
    public function view_list_of_articles()
    {
        try{

            $articles = $this->index(['page_id' => getIdByName(Page::class, 'Article', 'title')],[ 'id','title', 'created_at as date']);

            return api_response(data:$articles, message:'articles-getting-success');

        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()], message:'articles-getting-error', code:500);
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
        return search(Post::class,['category_id' => getIdByName(Category::class,'Article')],$query);
    }

}
