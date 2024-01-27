<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortalSettingRequest;
use App\Http\Resources\PortalSettingResource;
use App\Models\Portal_setting;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;


class PortalSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the portal settings by auth user
        $portal_settings = auth()->user()->portal_settings();

        return ($portal_settings->count() == 1)
            ? new PortalSettingResource($portal_settings->first())
            : PortalSettingResource::collection($portal_settings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PortalSettingRequest $request)
    {
        // Validate data
        $valid_data = $request->validated();

        // Create the portal setting
        $portal_setting = Portal_setting::create($valid_data);

        return new PortalSettingResource($portal_setting);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the portal setting by id and check if exists
        try {
            $data = getAndCheckModelById(Portal_setting::class, $id);

            return new PortalSettingResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PortalSettingRequest $request, string $id)
    {
        // Get the portal setting by id and check if exists
        try {
            $data = getAndCheckModelById(Portal_setting::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }
        // Validate data
        $valid_data = $request->validated();

        // Update the portal setting
        $data->update($valid_data);

        return new PortalSettingResource($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the portal setting by id and check if exists
        try {
            $data = getAndCheckModelById(Portal_setting::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }

        // Delete the portal setting
        $data->delete();

        return response()->json(['message' => 'Portal setting deleted successfully']);
    }
}
