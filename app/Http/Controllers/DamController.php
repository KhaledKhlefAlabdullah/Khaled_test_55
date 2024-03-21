<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dam\StoreDamRequest;
use App\Http\Requests\Dam\UpdateDamRequest;
use App\Http\Resources\DamResource;
use App\Models\Dam;
use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

class DamController extends Controller
{

    /**
     * Get Dams data
     */
    public function getData(){
        try{
            $data = Http::get('https://water.egat.co.th/API/1day/QwkOf1eK2rJy4Hu7bT8mGn5Vv4cF9pRa5Eq6xD2gZu3XkSeZ3j');
            return $data;
        }
        catch(Exception $e){

        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all Dams
        $dams = Dam::paginate();

        // Return DamResource collection
        return ($dams->count() == 1)
            ? new DamResource($dams->first())
            : DamResource::collection($dams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDamRequest $request)
    {
        // Validate the Dam
        $valid_data = $request->validated();

        // Create Dam
        $dam = Dam::create($valid_data);

        // Return DamResource
        return new DamResource($dam);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Get Dam by ID and check if it exists
            $dam = getAndCheckModelById(Dam::class, $id);

            // Return DamResource
            return new DamResource($dam);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDamRequest $request, string $id)
    {
        try {
            // Get Dam by ID and check if it exists
            $dam = getAndCheckModelById(Dam::class, $id);

            // Validate the Dam
            $valid_data = $request->validated();

            // Update Dam
            $dam->update($valid_data);

            // Return DamResource
            return new DamResource($dam);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Get Dam by ID and check if it exists
            $dam = getAndCheckModelById(Dam::class, $id);

            // Delete Dam
            $dam->delete();

            return response()->json(['message' => 'Dam deleted successfully']);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
