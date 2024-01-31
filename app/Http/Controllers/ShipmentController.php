<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the shipments by auth id
        $shipments = Shipment::whereStakeholderId(auth()->user()->id)->paginate();

        // return a collection of shipment resources using helper transformCollection
        return transformCollection($shipments, ShipmentResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create a new shipment
        $shipment = Shipment::create($valid_data);

        // return a shipment resource
        return new ShipmentResource($shipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the shipment by its ID and check if it exists
        try {
            $shipment = getAndCheckModelById(Shipment::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return new ShipmentResource($shipment);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ShipmentRequest $request, string $id)
    {
        // Get the shipment by its ID and check if it exists
        try {
            $shipment = getAndCheckModelById(Shipment::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
        $valid_data = $request->validated();

        // Update the shipment
        $shipment->update($valid_data);

        // return a shipment resource
        return new ShipmentResource($shipment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the shipment by its ID and check if it exists
        try {
            $shipment = getAndCheckModelById(Shipment::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        // Delete the shipment
        $shipment->delete();

        return response()->json([
            'message' => 'Shipment deleted successfully'
        ]);
    }
}
