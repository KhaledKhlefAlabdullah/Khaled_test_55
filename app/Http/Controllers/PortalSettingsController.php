<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortalSettingRequest;
use App\Models\PortalSetting;
use App\Models\User;

class PortalSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $user_id)
    {
        return User::findOrFail($user_id)->portal_settings;
    }

    /**
     * Show the form for creating a new resource.
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PortalSettingRequest $request)
    {
        $validData = $request->validated();

        PortalSetting::created($validData);
    }

    /**
     * Display the specified resource.
     */
    public function show(PortalSetting $portalSettings)
    {
        return PortalSetting::findOrFail($portalSettings->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(PortalSetting $portalSettings)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PortalSettingRequest $request, PortalSetting $portalSettings)
    {
        $updateData = $request->validated();

        $portalSettings->update($updateData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortalSetting $portalSettings)
    {
        PortalSetting::destroy($portalSettings->id);
    }
}
