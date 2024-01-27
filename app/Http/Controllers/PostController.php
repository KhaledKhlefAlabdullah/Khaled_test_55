<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

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
}
