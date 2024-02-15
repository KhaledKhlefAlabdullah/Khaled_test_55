<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndustrialAreas\IndustrialAreaRequest;
use App\Models\IndustrialArea;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use function App\Helpers\edit_file;
use function App\Helpers\fake_register_request;
use function App\Helpers\find_and_update;
use function App\Helpers\store_files;


class IndustrialAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            // get all industrial areas in database
            $industrial_areas = DB::table('user_profiles')
            ->join('users','user_profiles.user_id','=','users.id')
            ->join('industrial_areas','users.industrial_area_id','=','industrial_areas.id')
                ->select('industrial_areas.id as id', 'industrial_areas.name as industrial_area_name',
                    'industrial_areas.address', 'industrial_areas.image_url', 'users.email',
                    'user_profiles.name as user_name')->whereNull('users.deleted_at')->get();

            // return the data
            return response()->json([
                'industrial_areas' => $industrial_areas,
                'message' => __('industrial-areas-getting-success')
            ], 201);


        } // handling the exceptions
        catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('industrial-areas-getting-error')
            ], 501);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndustrialAreaRequest $request)
    {
        try {

            $image = $request->image;

            if (!is_null($image)) {

                $path = '/images/industrial_areas_images';

                $image_path = store_files($image, $path);

            } else {

                $image_path = '/images/industrial_areas_images/default_industrial_area.png';

            }

            // create new industrial area
            $industrial_area = IndustrialArea::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'image_url' => $image_path,
            ]);

            // create industrial area representative (user)
            // Simulate a request to the RegisteredUserController@store method
            $response = fake_register_request(
                industrial_area_id: $industrial_area->id,
                name: $request->input('representative_name'),
                email: $request->input('email'),
                password: '12345678',
                password_confirmation: '12345678',
                stakeholder_type: 'Industrial_area_representative',
                location: $industrial_area->address
            );

            return $response;

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('industrial-areas-creating-error')
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            // get industrial area database
            $industrial_area = DB::table('user_profiles')
                ->join('users', 'user_profiles.user_id', '=', 'users.id')
                ->join('industrial_areas', 'users.industrial_area_id', '=', 'industrial_areas.id')
                ->select('industrial_areas.id as id', 'industrial_areas.name as industrial_area_name',
                    'industrial_areas.address', 'industrial_areas.image_url', 'users.email', 'user_profiles.name as user_name')
                ->where('industrial_areas.id', '=', $id)->get();

            // return the data
            return response()->json([
                'industrial_area' => $industrial_area,
                'message' => __('industrial-areas-showing-success')
            ], 201);

        }
            // handling the exceptions
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('industrial-areas-showing-error')
            ],501);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndustrialAreaRequest $request, string $id)
    {
        try{

            // get the industrial area want to edite
            $industrial_area = IndustrialArea::findOrFail($id);

            $user = find_and_update(User::class,$industrial_area->id,['email'],[$request->input('email')]);

            $user_profile = find_and_update(UserProfile::class,$user->id,['name'],[$request->input('representative_name')]);

            $image = $request->image;

            $old_path = $industrial_area->image_url;

            if (!is_null($image)) {

                $path = '/images/industrial_areas_images';

                $image_url = edit_file($old_path, $image, $path);

            } else {

                $image_url = $old_path;

            }

            // update industrial area details
            $industrial_area->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'image_url' => $image_url
            ]);

            return response()->json([
                'industrial_area' => $industrial_area,
                'user_email' => $user->email,
                'user_name' => $user_profile->name,
                'message' => __('industrial-areas-editing-success')
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('industrial-areas-editing-error')
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustrialArea $industrial_area)
    {
        //
    }
}
