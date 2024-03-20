<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\PostRequest;
use App\Http\Requests\Posts\FilteringRequest;
use App\Http\Requests\Posts\GeneralNewsRequest;
use App\Models\Category;
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
    public function index($condations, $columns, $type = 'others')
    {
        if ($type == 'posts') {
            $posts = Post::where($condations)
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select($columns)->orderBy('posts.priority_count', 'desc')->get();
        } else {
            $posts = Post::where($condations)->select($columns)->get();
        }

        return $posts;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $category, $category_path)
    {
        try {

            $request->validated();

            $file_path = null;

            $file_type = null;

            if ($request->media) {

                $file = $request->media;

                $file_type = getMediaType($file);

                $path = $file_type . 's/' . $category_path;

                $file_path = store_files($file, $path);
            }

            $category_id =  getIdByName(Category::class, $category);



            if($category == 'posts'){
                $user_name = Auth::user()->user_profile->name;
                $title = is_null($user_name) ? 'anonnemoce post title' : $user_name.'posts title';
            }
            else{
                $title = $request->input('title');
            }

            Post::create([
                'user_id' => Auth::id(),
                'category_id' => $category_id,
                'title' => $title,
                'tag' => $request->input('tag'),
                'body' => $request->input('body'),
                'media_url' => $file_path,
                'media_type' => $file_type,
                'is_priority' => $request->input('is_priority'),
                'priority_count' =>  $request->input('priority_count'),
                'is_general_news' => $request->input('is_general_news') ? $request->input('is_general_news') : false,
                'is_publish' =>  $request->input('is_publish') ? $request->input('is_publish') : true,
                'created_at' => now()
            ]);

            return api_response(message: 'data-adding-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-adding-error', code: 500);
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

            $data = [
                'id' => $data->id,
                'title' => $data->title,
                'body' => $data->body,
                'media_url' => $data->media_url,
                'is_priority' => $data->is_priority,
                'created_at' => $data->created_at

            ];

            return api_response(data: $data, message: 'data-getting-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-getting-error', code: 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, string $category_path)
    {
        // Get the post by id and check if exists
        try {

            $data = getAndCheckModelById(Post::class, $id);

            $file_path = $data->media_url;

            $file_type = $data->media_type;

            if ($request->media && is_null($file_path)) {

                $file = $request->media;

                $file_type = getMediaType($file);

                $path = $file_type . 's/' . $category_path;

                $file_path = store_files($file, $path);
            } else if ($request->media && !is_null($file_path)) {

                $file = $request->media;

                $file_type = getMediaType($file);

                $old_path = $data->media_url;

                $new_path = $file_type . 's/' . $category_path;

                $file_path = edit_file($old_path, $file, $new_path);
            }

            $data->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'media_url' => $file_path,
                'media_type' => $file_type
            ]);

            return api_response(message: 'data-editing-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-editing-error', code: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the post by id and check if exists
        try {

            $data = getAndCheckModelById(Post::class, $id);

            if ($data->media_url) {
                unlink(public_path($data->media_url));
            }

            // Delete the post
            $data->delete();

            return api_response(message: 'data-deleted-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-deleted-error', code: 500);
        }
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
                ->select(
                    'posts.id',
                    'user_profiles.name',
                    'categories.name',
                    'posts.title',
                    'posts.body',
                    'posts.media_url as image'
                )
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
            $category_id = getIdByName(Category::class, 'News');

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
            send_notifications(User::all(), config('golbals.new-generalNews'), ['database']);

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

            $articles = $this->index(['category_id' => getIdByName(Category::class, 'Articles')], ['id', 'title', 'body', 'media_url', 'is_priority', 'created_at']);

            return api_response(data: $articles, message: 'articles-getting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'articles-getting-error', code: 500);
        }
    }

    // Search for articale
    public function search_article(string $query)
    {
        return search(Post::class, ['category_id' => getIdByName(Category::class, 'Articles')], $query);
    }

    // Add article
    public function add_article(PostRequest $request)
    {
        return $this->store($request, 'Articles', 'articles');
    }

    // For News
    /**
     * View the News: News - date of publication -news source		
     */
    public function view_news()
    {
        return $this->index(['category_id' => getIdByName(Category::class, 'News')], ['id', 'title', 'body', 'media_url', 'is_priority', 'created_at']);
    }

    /**
     * Search For an news
     */
    public function search_news(string $query)
    {
        return search(Post::class, ['category_id' => getIdByName(Category::class, 'News')], $query);
    }

    /**
     * Add news
     */
    public function add_news(PostRequest $request)
    {
        return $this->store($request, 'News', 'news');
    }

    /**
     * Add news
     */
    public function edit_news(PostRequest $request, string $id)
    {
        return $this->update($request, $id, 'news');
    }

    // For posts
    /**
     * View posted posts in the portal ( Published date- Upvotes- publisher:name,profile image- content-Tag)					
     */
    public function view_posts()
    {
        return $this->index(['category_id' => getIdByName(Category::class, 'posts')], ['posts.id as post_id', 'posts.created_at', 'posts.priority_count', 'posts.body', 'posts.media_url', 'user_profiles.name', 'user_profiles.avatar_url', 'posts.tag'], type: 'posts');
    }

    /**
     * Search For an posts
     */
    public function search_posts(string $query)
    {
        return search(Post::class, ['category_id' => getIdByName(Category::class, 'posts')], $query);
    }

    /**
     * Add posts
     * Create a post (description- Tags -attach a file (img, video..etc) )					
     */
    public function add_posts(PostRequest $request)
    {
        return $this->store($request, 'posts', 'posts');
    }

    /**
     * Add posts
     */
    public function edit_posts(PostRequest $request, string $id)
    {
        return $this->update($request, $id, 'posts');
    }

    /**
     * Filter Posts by: posting Date range- publisher- Tag					
     */
    public function filtering_posts(FilteringRequest $request)
    {
        try {

            $posts = Post::query();

            // Filter by posting date range
            if ($request->has('date_range') && is_array($request->date_range) && count($request->date_range) === 2) {
                // Extract start and end dates from the request array
                // strtotime: it's to convert the string input to timestamp
                $startDate = date('Y-m-d', strtotime($request->date_range[0]));
                $endDate = date('Y-m-d', strtotime($request->date_range[1]));

                // Ensure that start date is before end date
                if ($startDate <= $endDate) {
                    // Apply the date range filter
                    $posts->whereRaw("DATE(posts.created_at) BETWEEN '$startDate' AND '$endDate'");
                } else {
                    // If the start date is after the end date, handle the error or return appropriate response
                    return api_response(errors: ['Start date should be before or equal to end date.'], message: 'date-range-error', code: 400);
                }
            }

            // Filter by publisher_name
            if ($request->has('publisher_name')) {
                // check whil the post has user and pass the query 
                $posts->whereHas('users', function ($query) use ($request) {
                    // check whil the users has user_profiles and pass the query
                    $query->whereHas('user_profiles', function ($sub_query) use ($request) {
                        // check the user_profiles.name if contain the request (publisher_name) by the query
                        $sub_query->where('name', 'like', '%' . $request->publisher_name . '%');
                    });
                });
            }

            // Filter by tag
            if ($request->has('tag')) {
                $posts->where('tag', 'like', '%' . $request->tag . '%');
            }

            // Execute the query and retrieve filtered posts
            $filtered_posts = $posts->join('users', 'posts.user_id', '=', 'users.id')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select(['posts.id as post_id', 'posts.created_at', 'posts.priority_count', 'posts.body', 'posts.media_url', 'user_profiles.name', 'user_profiles.avatar_url', 'posts.tag'])->get();

            return api_response(data: $filtered_posts, message: 'posts-filtered-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'data-filtering-error', code: 500);
        }
    }

    /**
     * Upvot posts
     */
    public function upvot_posts(string $id)
    {
        try {

            $post = getAndCheckModelById(Post::class, $id);

            $post->update([
                'priority_count' => $post->priority_count + 1
            ]);

            return api_response(message: 'post-upvoting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'post-upvoting-error', code: 500);
        }
    }
}
