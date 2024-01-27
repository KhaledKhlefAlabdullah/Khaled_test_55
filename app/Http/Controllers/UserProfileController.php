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

            if($user_type == 'Industrial_area_representative'){

                // name from user_profiles
                // email from users
                // contact person from user_profiles
                // profile image from user_profiles

                $user_profile = DB::table('users')
                    ->join('user_profiles','users.id','=','user_profiles.user_id')
                    ->select('user_profiles.name as name','users.email as email','user_profiles.contact_person  as contact_person',
                        'user_profiles.avatar_URL  as profile_image')->where('users.id','=',$user_id)->get();

            }elseif ($user_type =='Tenant_company'){

                // todo i will contain tomoro
                // name from user_profiles
                // email from users
                // phone from user_profiles

            }elseif($user_type =='Infrastructure_provider'){

                // name from user_profiles
                // email from users
                // infrastructure_type from stakeholders
                // phone from user_profiles
                // location from user_profiles
                // contact person from user_profiles

                $user_profile = DB::table('users')
                    ->join('user_profiles','users.id','=','user_profiles.user_id')
                    ->join('stakeholders','users.id','=','stakeholders.user_id')
                    ->select('user_profiles.name as name','users.email as email','stakeholders.infrastructure_type as infrastructure_type',
                    'user_profiles.phone_number as phone','user_profiles.location as location','user_profiles.contact_person as contact_person')
                    ->where('users.id','=',$user_id)->get();

            }elseif($user_type =='Government_representative'){

                // todo i will contain tomoro

            }else{
                // todo i will contain tomoro
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
     * Show the form for editing the specified resource.
     */
    public function edit(User_profile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User_profile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_profile $userProfile)
    {
        //
    }
}
