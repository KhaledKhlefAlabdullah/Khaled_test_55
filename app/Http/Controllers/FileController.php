<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Auth;

use function App\Helpers\api_response;
use function App\Helpers\edit_file;
use function App\Helpers\gatMediaType;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getMediaType;
use function App\Helpers\store_files;
use function App\Helpers\transformCollection;

class FileController extends Controller
{
    /**
     * Retrieve and paginate manuals and plans files.
     *
     * This function fetches files of type 'Manuals & Plans' from the database,
     * paginates the results, and transforms the file data using the specified
     * resource class before returning it.
     *
     * @return LengthAwarePaginator
     */
    public function view_manuals_and_plans()
    {
        $files = File::where('file_type', '=', 'Manuals & Plans')->paginate();

        // Using a custom transformCollection function to format the response
//        return transformCollection($files, FileResource::class);

        return api_response(data: $files->items(),
            message: "Get Manuals and Plans Successfully",
            pagination: $files);
    }

    /**
     * Add manuals and plans
     */
    public function add_manuals_and_plans(FileRequest $request)
    {
        return $this->store($request, 'ManualsAndPlans');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get files by auth user ID
        $files = File::where('user_id', auth()->user()->id)->get();

        return ($files->count() == 1)
            ? new FileResource($files->first())
            : FileResource::collection($files);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $file_type)
    {
        try {

            $request->validated();

            $file = $request->file;

            $path = '/files/' . $request->input('file_type');

            $path = store_files($file, $path);

            File::create([
                'user_id' => Auth::id(),
                'category_id' => $request->input('category_id'),
                'file_type' => $file_type,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'version' => $request->input('version'),
                'media_url' => $path,
                'media_type' => getMediaType($file)
            ]);
            return response()->json([
                'message' => __('file-adding-success')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('file-adding-error')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get file by ID
        $file = File::find($id);

        // Check if file exists
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return new FileResource($file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $request, string $id)
    {
        try {

            $request->validated();

            // Get file by ID
            $file_ = getAndCheckModelById(File::class, $id);

            $file = $request->file;

            $path = '/files/' . $request->input('file_type');

            $old_path = $file_->media_url;

            $new_file_path = edit_file($old_path, $file, $path);

            $file_->update([
                'category_id' => $request->input('category_id'),
                'file_type' => $request->input('file_type'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'version' => $request->input('version'),
                'media_url' => $new_file_path,
                'media_type' => getMediaType($file)
            ]);

            return response()->json([
                'message' => __('file-editing-success')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('file-editing-error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get file by ID
        $file = getAndCheckModelById(File::class, $id);

        // Check if file exists
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Check if user is authorized
        if ($file->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Delete file
        $file->delete();

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
