<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {

            $user = Auth::user();

            $user_type = $user->stakeholder_type;

            $user_id = $user->id;

            $user_profile = null;

            switch ($user_type){

                case 'Industrial_area_representative':

                    // name from user_profiles
                    // email from users
                    // location from user_profiles
                    // contact person from user_profiles
                    // profile image from user_profiles

                    $user_profile = DB::table('users')
                        ->join('user_profiles','users.id','=','user_profiles.user_id')
                        ->select('user_profiles.name as name','users.email as email','user_profiles.contact_person  as contact_person',
                            'user_profiles.location as location','user_profiles.avatar_URL  as profile_image')->where('users.id','=',$user_id)->get();
                    break;
                case 'Tenant_company':

                    // name from user_profiles
                    // email from users
                    // phone from user_profiles
                    // location from user_profiles
                    // profile image from user_profiles
                    // company representative name from stakeholders
                    // job title from stakeholders

                    $user_profile = DB::table('users')
                        ->join('user_profiles','users.id','=','user_profiles.user_id')
                        ->join('stakeholders','users.id','=','stakeholders.user_id')
                        ->select('user_profiles.name as name','users.email as email','user_profiles.phone_number as phone',
                            'user_profiles.location as location','user_profiles.avatar_URL  as profile_image','stakeholders.company_representative_name as company_representative_name',
                            'stakeholders.job_title as job_title')->where('users.id','=',$user_id)->get();
                    break;
                case 'Infrastructure_provider':

                    // name from user_profiles
                    // email from users
                    // infrastructure_type from stakeholders
                    // phone from user_profiles
                    // location from user_profiles
                    // contact person from user_profiles
                    // profile image from user_profiles

                    $user_profile = DB::table('users')
                        ->join('user_profiles','users.id','=','user_profiles.user_id')
                        ->join('stakeholders','users.id','=','stakeholders.user_id')
                        ->select('user_profiles.name as name','users.email as email','stakeholders.infrastructure_type as infrastructure_type',
                            'user_profiles.phone_number as phone','user_profiles.avatar_URL  as profile_image','user_profiles.location as location','user_profiles.contact_person as contact_person')
                        ->where('users.id','=',$user_id)->get();

                    break;
                case 'Government_representative':

                    // name from user_profiles
                    // email from users
                    // phone from user_profiles
                    // location from user_profiles
                    // government representative agency from stakeholders
                    // profile image from user_profiles

                    $user_profile = DB::table('users')
                        ->join('user_profiles','users.id','=','user_profiles.user_id')
                        ->join('stakeholders','users.id','=','stakeholders.user_id')
                        ->select('user_profiles.name as name','users.email as email','user_profiles.phone_number as phone',
                            'user_profiles.location as location','user_profiles.avatar_URL  as profile_image','stakeholders.representative_government_agency as representative_government_agency')
                        ->where('users.id','=',$user_id)->get();

                    break;
                default:

                    throw new \Exception("You dont have user profile");

            }

            return response()->json([
                'user_profile' => $user_profile,
                'message' => __('successfully get user profile')
            ],200);


        }
        catch (\Exception $e){

            return response()->json([

                'error' => __($e->getMessage()),
                'message' => __('There are error in server side')

            ],500);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|min:3',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'location' => 'required|string',
                'profile_image' => 'required|string '
                    //'image|mimes:jpeg,png,gif,bmp'
            ]);

            $user = Auth::user();

            $user_type = $user->stakeholder_type;

            switch ($user_type){

                case 'Industrial_area_representative':

                    // name to user_profiles
                    // email to users
                    // location from user_profiles
                    // contact person to user_profiles
                    // profile image to user_profiles

                    $request->validate([
                        'contact_person' => 'required|string|min:3'
                    ]);

                    $user->update([
                        'email' => $request->input('email')
                    ]);

                    $user->user_profile()->update([
                        'name' => $request->input('name'),
                        'contact_person' => $request->input('contact_person'),
                        'location' => $request->input('location'),
                        'avatar_URL' => $request->input('profile_image'),
                    ]);

                    break;
                case 'Tenant_company':

                    // name to user_profiles
                    // email to users
                    // phone to user_profiles
                    // location to user_profiles
                    // profile image to user_profiles
                    // company representative name to stakeholders
                    // job title to stakeholders

                    $request->validate([
                        'phone_number' => 'required|string|regex:/^[0-9]{9,20}$/',
                        'contact_person' => 'required|string|min:3|max:50',
                        'company_representative_name' => 'required|string|min:3',
                        'job_title' => 'required|string|min:3'
                    ]);

                    $user->update([
                        'email' => $request->input('email')
                    ]);

                    $user->user_profile()->update([
                        'name' => $request->input('name'),
                        'phone_number' => $request->input('phone_number'),
                        'contact_person' => $request->input('contact_person'),
                        'location' => $request->input('location'),
                        'avatar_URL' => $request->input('profile_image'),
                    ]);

                    $user->stakeholder()->update([
                        'company_representative_name' => $request->input('company_representative_name'),
                        'job_title' => $request->input('job_title')
                    ]);

                    break;
                case 'Infrastructure_provider':

                    // name to user_profiles
                    // email to users
                    // infrastructure_type to stakeholders
                    // phone to user_profiles
                    // location to user_profiles
                    // contact person to user_profiles
                    // profile image to user_profiles

                    $request->validate([
                        'phone_number' => 'required|string|regex:/^[0-9]{9,20}$/',
                        'contact_person' => 'required|string|min:3|max:50',
                        'infrastructure_type' => 'required|string|min:3',
                    ]);

                    $user->update([
                        'email' => $request->input('email')
                    ]);

                    $user->user_profile()->update([
                        'name' => $request->input('name'),
                        'phone_number' => $request->input('phone_number'),
                        'contact_person' => $request->input('contact_person'),
                        'location' => $request->input('location'),
                        'avatar_URL' => $request->input('profile_image'),
                    ]);

                    $user->stakeholder()->update([
                        'infrastructure_type' => $request->input('infrastructure_type')
                    ]);

                    break;
                case 'Government_representative':

                    // name to user_profiles
                    // email to users
                    // phone to user_profiles
                    // location to user_profiles
                    // government representative agency to stakeholders
                    // profile image to user_profiles

                    $request->validate([
                        'phone_number' => 'required|string|regex:/^[0-9]{9,20}$/',
                        'representative_government_agency' => 'required|string|min:3',
                    ]);

                    $user->update([
                        'email' => $request->input('email')
                    ]);

                    $user->user_profile()->update([
                        'name' => $request->input('name'),
                        'phone_number' => $request->input('phone_number'),
                        'location' => $request->input('location'),
                        'avatar_URL' => $request->input('profile_image'),
                    ]);

                    $user->stakeholder()->update([
                        'representative_government_agency' => $request->input('representative_government_agency')
                    ]);


                    break;
                default:

                    throw new \Exception("You dont have user profile");

            }

            return response()->json([
                'message' => __('successfully editing user profile')
            ],200);


        }
        catch (\Exception $e){

            return response()->json([

                'error' => __($e->getMessage()),
                'message' => __('There are error in server side')

            ],500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_profile $userProfile)
    {
        //
    }
}
