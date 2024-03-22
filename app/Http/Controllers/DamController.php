<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dam\StoreDamRequest;
use App\Http\Requests\Dam\UpdateDamRequest;
use App\Http\Resources\DamResource;
use App\Models\Dam;
use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getPortalId;

class DamController extends Controller
{
    //Dam_data=
    // {
    //     "datetime": "21-03-2024",
    //     "damname": "BHUMIBOL DAM",
    //     "waterlevel": 239.07,
    //     "tailwater": 139.77,
    //     "inflow": 1.17,
    //     "released": 25.08,
    //     "storage": 7799.42,
    //     "spillway": 0,
    //     "losses": 0,
    //     "evap": 0.07
    // }
    /**
     * Get Dams data
     */
    public function getDamsData()
    {
        try {
            $response = Http::get('https://water.egat.co.th/API/1day/QwkOf1eK2rJy4Hu7bT8mGn5Vv4cF9pRa5Eq6xD2gZu3XkSeZ3j');

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data as $dam) {
                    // Check if the dam with the same name already exists
                    $existingDam = Dam::where('name', $dam['damname'])->first();

                    if (!$existingDam) {
                        // Create a new Dam record only if it doesn't exist

                        Dam::create([
                            'user_id' => getPortalId(),
                            'name' => $dam['damname'],
                            'location' => '',
                            'water_level' => $dam['waterlevel'],
                            'discharge' => '',
                            'source' => '',
                            'Dam_data' => json_encode($dam)
                        ]);
                    }
                }
            }
            return api_response(data:Dam::all(),message:'adding-dams-success');
        } catch (Exception $e) {
            return api_response(errors: $e->getMessage(), message: 'adding-dams-error', code: 500);
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
    public function destroy_all()
    {
        try {
            // Get Dam by ID and check if it exists
            $dams = Dam::all();

            // Delete Dam
            foreach($dams as $dam)
             $dam->delete();

            return response()->json(['message' => 'Dam deleted successfully']);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
