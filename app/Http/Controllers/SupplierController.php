<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\api_response;
use function App\Helpers\count_items;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\stakeholder_id;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $stakeholder_id = stakeholder_id();

            $suppliers = DB::table('stakeholders')
                ->join('suppliers', 'stakeholders.id', '=', 'suppliers.stakeholder_id')
                ->join('entities as routes', 'suppliers.route_id', '=', 'routes.id')
                ->join('entities as materials', 'suppliers.material_id', '=', 'materials.id')
                ->select('suppliers.id as supplier_id', 'materials.id as material_id',
                    'routes.id as route_id', 'suppliers.public_id as supplier_number', 'suppliers.contact_info as contct_number',
                    'materials.name as material', 'suppliers.location as location', 'routes.public_id as route')
                ->where('stakeholders.id', '=', $stakeholder_id)
                ->whereNull('suppliers.deleted_at')
                ->whereNull('routes.deleted_at')
                ->whereNull('materials.deleted_at')
                ->get();


            return response()->json([
                'suppliers' => $suppliers,
                'message' => __('Successfully getting suppliers')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        try {

            $suppliers_count = count_items(Supplier::class, ['stakeholder_id' => $request->stakeholder_id]);

            // Create the supplier
            Supplier::create([
                'stakeholder_id' => $request->stakeholder_id,
                'route_id' => $request->input('route_id'),
                'material_id' => $request->input('material_id'),
                'public_id' => $suppliers_count . 'SUP',
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'contact_info' => $request->input('contact_info'),
                'is_available' => $request->input('is_available')
            ]);

            // Return data
            return response()->json([
                'message' => __('Successfully adding new supplier')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ], 500);
        }
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
            return response()->json(['message' => __($e->getMessage())], $e->getCode());
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

            $supplier->update([
                'route_id' => $request->input('route_id'),
                'material_id' => $request->input('material_id'),
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'contact_info' => $request->input('contact_info'),
                'is_available' => $request->input('is_available')
            ]);

            return response()->json([
                'message' => __('Successfully editing supplier')
            ], 200);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
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


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function view_current_status_suppliers()
    {
        return api_response();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function view_future_status_suppliers()
    {
        return api_response();
    }

}
