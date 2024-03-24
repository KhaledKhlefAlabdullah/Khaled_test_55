<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementsRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\api_response;
use function App\Helpers\edit_file;
use function App\Helpers\getAndCheckModelById;

class AnnouncementsController extends Controller
{

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
                ->select(['id', 'user_id', 'title', 'body', 'is_publish', 'media_url'])->get();

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
     * This method excepts 'id' and 'is_publish' in the request.
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


    /**
     * Edit my  Announcement
     *
     */
    public function edit_announcements(AnnouncementsRequest $request, string $id)
    {
        try {

            $data = Post::findOrFail($id);

            if (is_null($request->image)) {

                $image_path = $data->media_url;

            } else {
                // get image from request
                $new_image = $request->image;

                // put path to store image
                $path = '/images/announcements';

                // get old file path
                $old_file_path = $data->media_url;

                // coll store function to store the image
                $image_path = edit_file($old_file_path, $new_image, $path);
            }

            // create new post as general news
            $data->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'media_url' => $image_path,
                'is_publish' => $request->input('is_publish'),
            ]);

            // return response with created data
            return api_response(
                data: $data,
                message: "Edit announcements Successfully"
            );


        } catch (\Exception $e) {

            return api_response(
                message: $e->getMessage(),
                code: $e->getCode() ?? 500,
                errors: ['Edit Announcements Error']
            );

        }
    }

    /*
     * view_announcements
     * see Announcements about urgent changes and updates in any interface
     */
    public function view_announcements()
    {
        try {
            // Get list of announcements
            // this id 048e9200-e29b-41d4-a716-446655440000 for announcements category
            $data = Post::where('category_id', '=', '048e9200-e29b-41d4-a716-446655440000')
                ->select(['id', 'user_id', 'title', 'body', 'is_publish', 'media_url'])->get();

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


    public function delete_announcements(string $id)
    {
        try {
            $data = getAndCheckModelById(Post::class, $id);

            $data->delete();

            return api_response(
                message: __('deleted-successfully')
            );

        } catch (NotFoundResourceException $e) {

            return api_response(
                message: __('not-found'),
                code: $e->getCode() ?? 404,
                errors: [$e->getMessage()]
            );

        }
    }


    public function add_announcements(AnnouncementsRequest $request)
    {
        $data = Post::create($request->all());

        return api_response(
            data: $data,
            message: __('created-successfully')
        );
    }

}
