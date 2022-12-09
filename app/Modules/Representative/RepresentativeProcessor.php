<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/2/18
 * Time: 4:52 PM
 */

namespace App\Modules\Representative;

use App\RepresentativeInvitation;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RepresentativeProcessor
{


    function __construct()
    {
    }


    public function getRepresentativeProfiles(){
        $all = DB::table('representative_invitations')
            ->join('user_profiles', 'representative_invitations.invited_id', '=', 'user_profiles.user_id')
            ->select('user_profiles.*')
            ->where('representative_invitations.response', 1)
            ->get();
        $profiles = [];
        foreach ($all as $data){
            array_push($profiles, json_decode($data->label_value, true));
        }
        return $profiles;
    }
}