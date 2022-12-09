<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/2/18
 * Time: 2:44 PM
 */

namespace App\Modules\SuperAdmin;

use App\Events;
use App\Library\Library;
use App\RepresentativeInvitation;
use App\SpeakerInvitation;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SuperAdminAction
{
    private $Lib;

    function __construct()
    {
        $this->Lib = new Library();
    }


    public function processInvitation($request){
        $token = $this->Lib->generateToken(20);

        if($request['inviteToBe'] == 'Representative'){
            $request['reg_link'] = $this->Lib->baseDomain()."/register";
            $request['invitation_link'] = $this->Lib->baseDomain()."/invitation/respond_to_invitation/".$token."?invited_by=".Auth::id()."&invite_to_be=Representative";
            $this->saveInvitationInfo($inviteToBe = 'Representative', $request['email'], $request['msg'], $token);

            Mail::send('mailPages.invite-to-be-representative', ['request' => $request], function ($mail) use ($request){
                $mail->from('vclass@eaas.bdren.net.bd', 'BdREN');
                $mail->to($request['email'])->subject('Virtual Classroom');
            });
        }
        elseif($request['inviteToBe'] == 'Speaker'){
            $request['reg_link'] = $this->Lib->baseDomain()."/register";
            $request['invitation_link'] = $this->Lib->baseDomain()."/invitation/respond_to_invitation/".$token."?invited_by=".Auth::id()."&invite_to_be=Speaker";
            $this->saveInvitationInfo($inviteToBe = 'Speaker', $request['email'], $request['msg'], $token);

            Mail::send('mailPages.invite-to-be-speaker', ['request' => $request], function ($mail) use ($request){
                $mail->from('vclass@eaas.bdren.net.bd', 'BdREN');
                $mail->to($request['email'])->subject('Virtual Classroom');
            });
        }
    }


    public function saveInvitationInfo($inviteToBe ,$email, $msg, $token){
        $invited = User::where('email', $email)->get();
        if( count($invited) == 1 ){
            $invited = $invited[0];
        }else{
            $invited->id = 0;
        }
        if($inviteToBe == 'Representative'){
            $invitationInfo = RepresentativeInvitation::firstOrNew([
                'invited_id'        => $invited->id
            ]);
        }elseif($inviteToBe == 'Speaker'){
            $invitationInfo = SpeakerInvitation::firstOrNew([
                'invited_id'        => $invited->id
            ]);
        }
        $invitationInfo->invited_by = Auth::id();
        $invitationInfo->invited_at = Carbon::now();
        $invitationInfo->msg = $msg;
        $invitationInfo->token = $token;
        $invitationInfo->save();
    }

    public function fetchUnseenNotifications(){
        $upcomingEvents = Events::where('talk_delivery_time', '>=', Carbon::now())
            ->where('seen_by', 'not like', '%,'.Auth::id().',%')->orWhere('seen_by', null)
            ->select('id', 'title', 'created_at')->get();
        $representativeInvitation = DB::table('representative_invitations as re')
            ->join('users', 'users.id', 're.invited_id')
            ->select('re.id', 're.invited_id', 're.invited_at','users.name')
            ->where('re.seen_by', 'not like', '%,'.Auth::id().',%')->orWhere('re.seen_by', null)
            ->where('re.response', 1)
            ->get();
        $speakerInvitation = DB::table('speaker_invitations as sp')
            ->join('users', 'users.id', 'sp.invited_id')
            ->select('sp.id', 'sp.invited_id', 'users.name')
            ->where('sp.seen_by', 'not like', '%,'.Auth::id().',%')->orWhere('sp.seen_by', null)
            ->where('sp.response', 1)
            ->get();
        //$gotUserRole =

        $notifications = [];
        foreach ($upcomingEvents as $event){
            array_push($notifications, "<b>New Event : </b>"."<a id='".($event->id)."' source='events' target='_blank' class='notification-link' href='/event/".($event->id)."'>$event->title</a>");
        }
        foreach ($representativeInvitation as $invitation){
            array_push($notifications, "<span id='".($invitation->id)."' source='representative_invitations' class='notification-link' >$invitation->name responded to your invitation to be a representative</span>");
        }
        foreach ($speakerInvitation as $invitation) {
            array_push($notifications, "<span id='".($invitation->id)."' source='speaker_invitations' class='notification-link' >$invitation->name responded to your invitation to be a speaker</span>");
        }

        return $notifications;
    }

    public function getRepresentativeProfiles(){

    }
}