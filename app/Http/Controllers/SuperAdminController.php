<?php

namespace App\Http\Controllers;

use App\Events;
use App\Library\Library;
use App\Modules\Misc\DefaultValue;
use App\Modules\Misc\HardCodedData;
use App\Modules\Representative\RepresentativeProcessor;
use App\Modules\SuperAdmin\SuperAdminAction;
use App\RepresentativeInvitation;
use App\User;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    private $Lib, $SuperAdmin, $Representative, $DefaultValue, $HardCodedData;

    function __construct()
    {
        $this->middleware('auth');

        $this->Lib = new Library();
        $this->SuperAdmin = new SuperAdminAction();
        $this->Representative = new RepresentativeProcessor();
        $this->DefaultValue = new DefaultValue();
        $this->HardCodedData = new HardCodedData();
    }


    public function index(){
        if($this->Lib->getUserRole(Auth::id()) == 'Super Admin'){
            $invitedPersons = DB::table('representative_invitations')
                ->join('users', 'representative_invitations.invited_id', '=', 'users.id')
                ->select('representative_invitations.invited_at', 'users.id', 'users.name','users.email')
                ->where('representative_invitations.response', 0)
                ->get();
            $representativeProfiles = $this->Representative->getRepresentativeProfiles();
            $unapprovedEvents = Events::where('talk_delivery_time', '>=', Carbon::now())
                ->where('approved', 0)->get();
            foreach ($unapprovedEvents as $event){
                $event['speakerName'] = $this->Lib->getUserName($event->speaker_id);
            }

            $UnseenNotifications = $this->SuperAdmin->fetchUnseenNotifications();
            $univInfo = $this->HardCodedData->univInfo();
            sort($univInfo);

            $upcomingEvents = Events::where('talk_delivery_time', '>=', Carbon::now())
                ->where('approved', 1)->get();

            return view('superadmin.super-panel', [
                'invitedPersons'            => $invitedPersons,
                'representativeProfiles'    => $representativeProfiles,
                'unapprovedEvents'          => $unapprovedEvents,
                'upcomingEvents'            => $upcomingEvents,
                'UnseenNotifications'       => $UnseenNotifications,
                'emailMsgToSpeaker'         => $this->DefaultValue->emailMsgToSpeaker(),
                'emailMsgToRepresentative'  => $this->DefaultValue->emailMsgToRepresentative(),
                'univInfo'                  => $univInfo,
            ]);
        }
        return redirect('/');
    }



    public function inviteToComeInRole(Request $request){
        $email = $request['email'];

        $this->SuperAdmin->processInvitation($request);
        echo "sent";




//        $user = User::where('email', $email)->get();
//        if(count($user) == 0 ){
//            echo 404;
//        }else{
//            if( is_null( $this->Lib->getUserRole($user[0]->id) ) ){
//                $this->SuperAdmin->processInvitation($request);
//                echo "sent";
//            }
//            else{
//                echo "already invited";
//            }
//        }

    }

}
