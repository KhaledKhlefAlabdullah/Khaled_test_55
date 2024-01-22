<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortalSettingRequest;
use App\Models\Portal_setting;
use App\Models\PortalSetting;
use App\Models\User;

class PortalSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PortalSettingRequest $request)
    {
        $validData = $request->validated();

        Portal_setting::created($validData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Portal_setting $portalSettings)
    {
        return Portal_setting::findOrFail($portalSettings->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PortalSettingRequest $request, Portal_setting $portalSettings)
    {
        $updateData = $request->validated();

        $portalSettings->update($updateData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portal_setting $portalSettings)
    {
        Portal_setting::destroy($portalSettings->id);
    }
}
