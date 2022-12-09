<?php

namespace App\Http\Controllers;

use App\Events;
use App\Library\Library;
use App\Modules\Events\EventProcessor;
use App\Modules\SoftCode\FormField;
use App\RepresentativeInvitation;
use App\SpeakerInvitation;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $Lib, $FormField, $Event;

    function __construct()
    {
        $this->middleware('auth');
        $this->Lib = new Library();
        $this->FormField = new FormField();
        $this->Event = new EventProcessor();
    }


    public function index(){
        $upcomingEvents = Events::where('talk_delivery_time', '>=', Carbon::now())
            ->where('approved', 1)->get();
        $pastEvents = Events::where('talk_delivery_time', '<', Carbon::now())->get();
        foreach ($pastEvents as $event){
            $event['alreadyAttended'] = $this->Event->isAlreadyAttended($event->id, Auth::id());
        }
        foreach ($upcomingEvents as $event){
            $event['speakerName'] = $this->Lib->getUserName($event->speaker_id);
            $event['alreadyAttended'] = $this->Event->isAlreadyAttended($event->id, Auth::id());
            $event['attendedVia'] = $this->Event->attendedVia($event->id, Auth::id());
            $event['totalAttending'] = $this->Event->totalAttending($event->id);
        }
        return view('user.board', [
            'upcomingEvents'        => $upcomingEvents,
            'pastEvents'            => $pastEvents,
            'attendViaFormField'    => $this->FormField->attendToEventVia(),
        ]);
    }


    public function respondToInvitation(Request $request){
        $invitationToken = $request->route('token');
        $roleAssignedBy = isset($_GET['invited_by']) ? $_GET['invited_by'] : 0;
        $invitedToBe = isset($_GET['invite_to_be']) ? $_GET['invite_to_be'] : 0;

        if( $this->saveResponseInfo($role = $invitedToBe, $roleAssignedBy, $invitationToken) ){
            $userData['requestedById'] =  $roleAssignedBy;
            $userData['invitedToBe'] =  $invitedToBe;
            $userData['userName'] =  Auth::user()->name;
            Mail::send('mailPages.invite-response-msg-to-super', ['userData'=> $userData], function ($mail) use ($userData){
                $mail->from(Auth::user()->email, 'Virtual Classroom');
                $mail->to( User::find($userData['requestedById'])->email )->subject("Response to invitation");
            });
            if($role == 'Representative'){
                return view('representative.respond-to-invitation');
            }elseif ($role == 'Speaker'){
                return view('speaker.respond-to-invitation');
            }
        }
        return "You are visiting an incorrect link <br> Please Check mail and visit the correct link";
    }

    public function saveResponseInfo($role, $roleAssignedBy, $invitationToken){
        if( ! in_array($role, $this->Lib->availableUserRoles()) ){
            return false;
        }

        if($role == 'Representative'){
            $invited = RepresentativeInvitation::where('token', $invitationToken)->get();
        }elseif($role == 'Speaker'){
            $invited = SpeakerInvitation::where('token', $invitationToken)->get();
        }
        if(count($invited) > 0){
            $userRole = UserRole::firstOrNew([
                'user_id'           => Auth::id(),
            ]);
            $userRole->role = $role;
            $userRole->role_assigned_by = $roleAssignedBy;
            $userRole->save();
            if($role == 'Representative'){
                RepresentativeInvitation::where('invited_id', Auth::id())->update(['response' => 1, 'responded_at' => Carbon::now()]);
            }elseif ($role == 'Speaker'){
                SpeakerInvitation::where('invited_id', Auth::id())->update(['response' => 1, 'responded_at' => Carbon::now()]);
            }
            return true;
        }
        else{
            return false;
        }
    }
}
