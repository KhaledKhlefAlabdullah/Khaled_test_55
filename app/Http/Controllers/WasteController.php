<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wastes\WastesRequest;
use App\Models\Category;
use App\Models\Entity;
use App\Models\Waste;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\stakeholder_id;

class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // build query for get the wast nam and disposal and route
            $wastes = DB::table('entities as disposal')
                ->join('wastes', 'disposal.id', '=', 'wastes.waste_disposal_location_id')
                ->join('entities as routes', 'wastes.route_id', '=', 'routes.id')
                ->select('wastes.id', 'wastes.waste_name as waste',
                    'disposal.location as disposal_location', 'routes.public_id as Route')
                ->where('wastes.stakeholder_id', '=', stakeholder_id())->whereNull('wastes.deleted_at')->get();

            // return the data
            return response()->json([
                'data' => $wastes,
                'message' => __('wastes-get-success')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('wastes-get-error')
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WastesRequest $request)
    {
        try {

            // create new wast with validated data input
            Waste::create([
                'route_id' => $request->input('route_id'),
                'waste_disposal_location_id' => $request->input('disposal_location_id'),
                'stakeholder_id' => stakeholder_id(),
                'waste_name' => $request->input('waste')
            ]);

            // return success message
            return response()->json([
                'message' => __('waste-add-success')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('waste-add-error')
            ], 500);
        }
    }


    /**
     * Get the desposal locations
     */
    public function get_desposal_locations()
    {
        try{

            $category_id = getIdByName(Category::class,'Waste Disposal Site');

            $disposal_sites = Entity::where('category_id',$category_id)->select('id','name')->get();

            return response()->json([
                'data' => $disposal_sites,
                'message' => __('deisposal-get-success')
            ]);

        }
        catch(Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('deisposal-get-error')
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Waste $waste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waste $waste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WastesRequest $request, string $id)
    {
        try {

            // get and check the element
            $waste = getAndCheckModelById(Waste::class, $id);

            // update the element data
            $waste->update([
                'waste_name' => $request->input('waste'),
                'waste_disposal_location_id' => $request->input('disposal_location_id'),
                'route_id' => $request->input('route_id')
            ]);

            // return response with success message
            return response()->json([
                'message' => __('waste-edite-success')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('waste-edite-error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $waste = getAndCheckModelById(Waste::class, $id);

            if (empty($waste)) {
                return response()->json([
                    'message' => __('waste-delete-error')
                ], 404);
            }

            $waste->delete();

            return response()->json([
                'message' => __('waste-delete-success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('waste-delete-error')
            ], 404);
        }
    }
}
