<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get suppliers by auth user
        $suppliers = Supplier::whereStakeholderId(auth()->user()->id)->paginate();

        // Return data
        return transformCollection($suppliers, SupplierResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        // Validate the data
        $valid_data = $request->validated();

        // Create the supplier
        $supplier = Supplier::create($valid_data);

        // Return data
        return new SupplierResource($supplier);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the supplier by ID and check if it exists
        try {
            $supplier = getAndCheckModelById(Supplier::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, string $id)
    {
        // Get the supplier by ID and check if it exists
        try {
            $supplier = getAndCheckModelById(Supplier::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Validate the data
        $valid_data = $request->validated();

        // Update the supplier
        $supplier->update($valid_data);

        // Return data
        return new SupplierResource($supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the supplier by ID and check if it exists
        try {
            $supplier = getAndCheckModelById(Supplier::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the supplier
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
