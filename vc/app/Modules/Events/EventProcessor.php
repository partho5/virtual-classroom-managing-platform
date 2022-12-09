<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/6/18
 * Time: 10:32 PM
 */

namespace App\Modules\Events;

use App\EventParticipants;
use App\Events;
use App\Library\Library;
use App\Mail\EventMailing_Queue;
use App\Mail\NotifyAtEventCreation_MailQueue;
use App\Modules\Misc\HardCodedData;
use App\User;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class EventProcessor
{
    private $Lib, $HardCodedData;

    function __construct()
    {
        $this->Lib = new Library();
        $this->HardCodedData = new HardCodedData();
    }

    public function attend($eventId, $attendVia){
        try{
            $attend = EventParticipants::firstOrNew([
                'user_id'       => Auth::id(),
                'event_id'      => $eventId,
            ]);
            $attend->user_role = $this->Lib->getUserRole(Auth::id());
            $attend->attend_via = $attendVia;
            $attend->save();
            return true;
        }catch (Exception $e){
            return false;
        }
    }


    public function isAlreadyAttended($eventId, $userId){
        $event = EventParticipants::where('user_id', $userId)->where('event_id', $eventId)->get();
        return count($event) > 0 ? true : false;
    }

    public function attendedVia($eventId, $userId){
        $event = EventParticipants::where('user_id', $userId)->where('event_id', $eventId)->get();
        if(count($event) > 0){
            return $event[0]->attend_via;
        }
        return null; //never return 0 as default, 0 is preserved for a certain value
    }

    public function totalAttending($eventId){
        return EventParticipants::where('event_id', $eventId)->count();
    }

    public function messageToSpeakerOnApproveEvent($eventId, $request){
        $event = Events::find($eventId);
        $user = User::find($event->speaker_id);

        $speakerProfile = UserProfile::where('user_id', $event->speaker_id)->pluck('label_value')[0];
        $speakerProfile = json_decode($speakerProfile, true);
        $univInfo = $this->HardCodedData->univInfo();
        $speakerProfile['univ'] = $univInfo[ $speakerProfile['univ'] ]['univ_name'];
        $speakerProfile['pp_src'] = $this->Lib->baseDomain()."/uploaded/".$speakerProfile['pp_src'];
        $data['speakerProfile'] = $speakerProfile;

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['msg'] = "One event information has been edited";
        $data['event_details_pdf_link'] = $request['event_details_pdf_link'];
        $data['event'] = $event;
        Mail::send('mailPages.event.event-created-msg-to-speaker', ['data'=> $data], function ($mail) use ($data){
            $mail->from("cto@bdren.net.bd", "Virtual Classroom");
            $mail->to($data['email'])->subject("Virtual Classroom > Welcome Speaker");
        });
    }

//    public function messageToRepresentativeOnApproveEvent($eventId, $request){
//        $representativeIdsToNotify = $this->representativeIdsToNotify($eventId);
//        $users = User::whereIn('id', $representativeIdsToNotify)->select('email')->get();
//        $emailList = [];
//        foreach ($users as $user){
//            array_push($emailList, $user->email);
//
//            $event = Events::find($eventId);
//            $user = User::find($event->speaker_id);
//            $data['name'] = $user->name;
//            $data['email'] = $user->email;
//            $data['msg'] = $request['msg_sent_to_representative'];
//            $event->event_details_pdf_link = $this->generateEventDetailsPDF($eventId);
//            $data['event'] = $event;
//            Mail::send('mailPages.event.event-created-msg-to-representative', ['data'=> $data], function ($mail) use ($data){
//                $mail->from("cto@bdren.net.bd", "Virtual Classroom");
//                $mail->to($data['email'])->subject("Virtual Classroom > Welcome Representative");
//            });
//        }
//
////        try{
////            Mail::bcc($emailList)->queue(new NotifyAtEventCreation_MailQueue($data));
////            echo "------".(count($emailList))."------";
////        }catch (Exception $e){
////        }
//    }


    public function messageToRepresentativeOnEditEvent2($eventId){
        $users = DB::table('user_roles as ur')
            ->join('users as u', 'ur.user_id', '=', 'u.id')
            ->select('u.email', 'u.name')
            ->get();
        $emailList = [];
        foreach ($users as $user){
            array_push($emailList, $user->email);

            $event = Events::find($eventId);
            //$user = User::find($event->speaker_id);
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $event->event_details_pdf_link = $this->generateEventDetailsPDF($eventId);
            $data['event'] = $event;
            Mail::send('mailPages.event.notify-on-edit-event', ['data'=> $data], function ($mail) use ($data){
                $mail->from("cto@bdren.net.bd", "Virtual Classroom");
                $mail->to($data['email'])->subject("Virtual Classroom > Representative");
            });
        }
    }


    private function representativeIdsToNotify($eventId){
        $univIdToNotify = Events::where('id', $eventId)->select('univ_id_to_notify')->get();
        $univIdToNotify = json_decode($univIdToNotify[0]->univ_id_to_notify, true);

        $representatives = DB::table('user_roles as ur')->join('users as u', 'ur.user_id', '=', 'u.id')
            ->select('u.id')->where('ur.role', 'Representative')->get();
        $allRepresentativeIds = [];
        foreach ($representatives as $representative){
            array_push($allRepresentativeIds, $representative->id);
        }
        $profiles = UserProfile::whereIn('user_id', $allRepresentativeIds)->get();
        $representativeIdsToNotify = [];
        foreach ($profiles as $profile){
            $labelValue = $profile->label_value;
            $labelValue = json_decode($labelValue, true);
            if( in_array($labelValue['univ'], $univIdToNotify) ){
                array_push($representativeIdsToNotify, $profile->id);
            }
        }

        return $representativeIdsToNotify;
    }

    public function messageToUserOnApproveEvent($eventId){

    }

    public function generateEventDetailsPDF($eventId){
        $event = Events::find($eventId);
        $data['event'] = $event;

        $speakerProfile = UserProfile::where('user_id', $event->speaker_id)->pluck('label_value')[0];
        $speakerProfile = json_decode($speakerProfile, true);
        $univInfo = $this->HardCodedData->univInfo();
        $speakerProfile['univ'] = $univInfo[ $speakerProfile['univ'] ]['univ_name'];
        $speakerProfile['pp_src'] = $this->Lib->baseDomain()."/uploaded/".$speakerProfile['pp_src'];
        $data['speakerProfile'] = $speakerProfile;


        $html = view('generatePDF/event-details', ['data'=> $data])->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $savePath = 'generatedPDF/'.(Carbon::now()->format('d-m-Y').'_'.$event->client_dial_num).'.pdf';
        try{
            file_put_contents(public_path().'/'.$savePath, $pdf->stream('invoice.pdf'));
            return $this->Lib->baseDomain().'/'.$savePath;
        }catch (Exception $e){
            return null;
        }
    }

    public function storeEvent($request){

        $userRole = $this->Lib->getUserRole(Auth::id());
        if($userRole == 'Super Admin'){
            $request['creator_id'] = Auth::id();
            $request['approved'] = 1;
            $request['approved_by'] = Auth::id();
            $request['approved_at'] = Carbon::now();

            $event = Events::create($request->all());
        }
        elseif ($userRole == 'Speaker'){
            $request['creator_id'] = $request['speaker_id'] = Auth::id();
            $event = Events::create($request->all());
        }

        if($userRole == 'Super Admin'){
            $data['event_details_pdf_link'] = $this->generateEventDetailsPDF($event->id);
            $data['event'] = $event;
            $data['email'] = User::where('id', $request['speaker_id'])->pluck('email')[0];
            $data['name'] = $this->Lib->getUserName($request['speaker_id']);
            $data['msg'] = $request['msg_sent_to_speaker'];

            $speakerProfile = UserProfile::where('user_id', $event->speaker_id)->pluck('label_value')[0];
            $speakerProfile = json_decode($speakerProfile, true);
            $univInfo = $this->HardCodedData->univInfo();
            $speakerProfile['univ'] = $univInfo[ $speakerProfile['univ'] ]['univ_name'];
            $speakerProfile['pp_src'] = $this->Lib->baseDomain()."/uploaded/".$speakerProfile['pp_src'];
            $data['speakerProfile'] = $speakerProfile;

            Mail::send('mailPages.event.event-created-msg-to-speaker', ['data'=> $data], function ($mail) use ($data){
                $mail->from("cto@bdren.net.bd", "Virtual Classroom");
                $mail->to($data['email'])->subject("Virtual Classroom > Welcome Speaker");
            });

            $request['event_details_pdf_link'] = $data['event_details_pdf_link'];
            $this->messageToRepresentativeOnCreateOrApproveEvent($event->id, $request);
        }


        return $event;
    }

    public function messageToRepresentativeOnCreateOrApproveEvent($eventId, $request){
        $event = Events::find($eventId);

        $event->speakerName = $this->Lib->getUserName($event->speaker_id);

        $speakerProfile = UserProfile::where('user_id', $event->speaker_id)->pluck('label_value')[0];
        $speakerProfile = json_decode($speakerProfile, true);
        $univInfo = $this->HardCodedData->univInfo();
        $speakerProfile['univ'] = $univInfo[ $speakerProfile['univ'] ]['univ_name'];
        $speakerProfile['pp_src'] = $this->Lib->baseDomain()."/uploaded/".$speakerProfile['pp_src'];
        $data['speakerProfile'] = $speakerProfile;

        $data['event'] = $event;
        $data['msg'] = $request['msg_sent_to_representative'];
        $data['event_details_pdf_link'] = $request['event_details_pdf_link'];

        $univIdToNotify = json_decode($request['univ_id_to_notify'], true);

        if( is_array($univIdToNotify) ){
            foreach ($univIdToNotify as $univId){
                $univInfo = $this->HardCodedData->univInfo();
                $emails = $univInfo[$univId]['email'];
                foreach ($emails as $email){
                    $data['email'] = $email;
                    if($email){
                        Mail::send('mailPages.event.event-created-msg-to-representative', ['data'=> $data], function ($mail) use ($data){
                            $mail->from("cto@bdren.net.bd", "Virtual Classroom");
                            $mail->to($data['email'])->subject("Virtual Classroom > Welcome Representative");
                        });
                    }
                }
            }
        }
    }


    //its lazily written similar to messageToRepresentativeOnCreateOrApproveEvent()
    //need to re-define this method
    public function messageToRepresentativeOnEditEvent($eventId, $request){
        $event = Events::find($eventId);
        $event->speakerName = $this->Lib->getUserName($event->speaker_id);

        $speakerProfile = UserProfile::where('user_id', $event->speaker_id)->pluck('label_value')[0];
        $speakerProfile = json_decode($speakerProfile, true);
        //dd($speakerProfile);
        $univInfo = $this->HardCodedData->univInfo();
        $speakerProfile['univ'] = $univInfo[ $speakerProfile['univ'] ]['univ_name'];
        $data['speakerProfile'] = $speakerProfile;

        $data['event'] = $event;
        $data['msg'] = "One event information has been edited";
        $data['event_details_pdf_link'] = $this->generateEventDetailsPDF($eventId);


        $univIdToNotify = json_decode($request['univ_id_to_notify'], true);
        foreach ($univIdToNotify as $univId){
            $univInfo = $this->HardCodedData->univInfo();
            $emails = $univInfo[$univId]['email'];
            foreach ($emails as $email){
                $data['email'] = $email;
                if($email){
                    Mail::send('mailPages.event.event-created-msg-to-representative', ['data'=> $data], function ($mail) use ($data){
                        $mail->from("cto@bdren.net.bd", "Virtual Classroom");
                        $mail->to($data['email'])->subject("Virtual Classroom > Welcome Representative");
                    });
                }
            }
        }
    }
}