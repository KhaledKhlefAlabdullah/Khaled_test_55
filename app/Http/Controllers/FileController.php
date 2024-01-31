<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;

class FileController extends Controller
{
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
    public function store(FileRequest $request)
    {
        // Check if valid data
        $valid_data = $request->validated();

        // Create file
        $file = File::create($valid_data);

        return new FileResource($file);
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
        // Get file by ID
        $file = File::find($id);

        // Check if file exists
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Check if user is authorized
        if ($file->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Update file
        $file->update($request->all());

        return new FileResource($file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get file by ID
        $file = File::find($id);

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

        return response()->json(['message' => 'File deleted successfully']);
    }
}
