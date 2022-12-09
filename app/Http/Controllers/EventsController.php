<?php

namespace App\Http\Controllers;

use App\Events;
use App\Jobs\NotifyAtEventCreation_Job;
use App\Library\Library;
use App\Mail\NotifyAtEventCreation_MailQueue;
use App\Modules\Events\EventProcessor;
use App\Modules\Misc\DefaultValue;
use App\Modules\Misc\HardCodedData;
use App\User;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use PDF;

class EventsController extends Controller
{

    private $Lib, $Event, $HardCodedData, $DefaultValue;

    function __construct()
    {
        $this->middleware('auth');
        $this->Lib = new Library();
        $this->Event = new EventProcessor();
        $this->HardCodedData = new HardCodedData();
        $this->DefaultValue = new DefaultValue();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $speakers = UserRole::where('role', 'Speaker')->select('user_id')->get();
        foreach ($speakers as $speaker){
            $speaker->only_name = User::find($speaker->user_id)->name;
            $profile = UserProfile::where('user_id', $speaker->user_id)->pluck('label_value')[0];
            $profile = json_decode($profile, true);
            $univId = $profile['univ'];
            if( $univId ){
                $univInfo = $this->HardCodedData->univInfo();
                $speaker->value = $speaker->only_name. '('.($univInfo[$univId]['univ_name']).')';
            }else{
                $speaker->value = $speaker->only_name;
            }

            $speaker->id = $speaker->user_id;
            unset($speaker->user_id);
        }


        return $speakers;

        return [
            ['id' => 23, 'value' => "Partho (KUET)", 'only_name'=>'Partho'],
            ['id' => 23, 'value' => "Sourav (DU)", 'only_name'=>'Sourav'],
        ];

        $univToNotify = Events::where('id', 2)->select('univ_id_to_notify')->get();
        $univToNotify = json_decode($univToNotify[0]->univ_id_to_notify, true);
        return $univToNotify;

        echo "<h1>ALL EVENTS</h1>";
        $events = Events::all();
        dd($events);
        return "Show All event list here";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = UserProfile::where('user_id', Auth::id())->select('label_value')->get();
        $profile = json_decode($profile[0]->label_value, true);
        if( $this->Lib->getUserRole(Auth::id()) != 'Super Admin' ){
            if ( ! $profile['phone'] || ! $profile['pp_src'] || ! $profile['univ']){
                Session::put('warningMsg', "Please complete your profile for creating an event");
                return redirect('/user/profile');
            }
        }

        $userRole = $this->Lib->getUserRole(Auth::id());
        $univInfo = $this->HardCodedData->univInfo();
        sort($univInfo);
        return view('event.create', [
            'userRole'                  => $userRole,
            'adminPanelLink'            => $this->Lib->adminPanelLink(),
            'univInfo'                  => $univInfo,
            'emailMsgToSpeaker'         => $this->DefaultValue->emailMsgToSpeaker(),
            'emailMsgToRepresentative'  => $this->DefaultValue->emailMsgToRepresentative(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //return $request->all();

        $request['univ_id_to_notify'] = json_encode($request['univ_id_to_notify']);

        $allUserExceptThisUser = User::where('id', '!=', Auth::id())->select('email')->get();
        $mailList = [];
        foreach ($allUserExceptThisUser as $user){
            array_push($mailList, $user->email);
        }

        $request['creator_role'] = $this->Lib->getUserRole(Auth::id());

        $event = $this->Event->storeEvent($request);

        Mail::bcc($mailList)->queue(new NotifyAtEventCreation_MailQueue($event));
        Session::put('successMsg', "Thank you for creating the event");

        $role = $this->Lib->getUserRole(Auth::id());
        if($role == 'Speaker'){
            return redirect('/speaker');
        }
        elseif($role == 'Super Admin'){
            return redirect('/super');
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Events::find($id);
        $event['speaker_name'] = $this->Lib->getUserName($event->speaker_id);
        if($event){
            return view('event.show', [
                'event'     => $event,
            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userRole = $this->Lib->getUserRole(Auth::id());
        $event = Events::find($id);
        $event->speakerName = $this->Lib->getUserName($event->speaker_id);
        $univs = $event->univ_id_to_notify;
        $event->univs = json_decode($univs, true);
        $event->univs = is_null($event->univs) ? [] : $event->univs;
        if($event){
            return view('event.edit', [
                'event'             => $event,
                'userRole'          => $userRole,
                'adminPanelLink'    => $this->Lib->adminPanelLink(),
                'univInfo'                  => $this->HardCodedData->univInfo(),
                'emailMsgToSpeaker'         => $this->DefaultValue->emailMsgToSpeaker(),
                'emailMsgToRepresentative'  => $this->DefaultValue->emailMsgToRepresentative(),
            ]);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());

        $request['speaker_id'] = is_null($request['speaker_id']) ? $request['speaker_name'] : $request['speaker_id'];
        $request['univ_id_to_notify'] = json_encode($request['univ_id_to_notify']);


        unset($request['speaker_name']);
        unset($request['_token']);
        unset($request['_method']);
        Events::where('id', $id)->update($request->all());
        Session::put('successMsg', "Event data has been saved");


        $this->Event->messageToRepresentativeOnEditEvent($eventId = $id, $request);

        $role = $this->Lib->getUserRole(Auth::id());
        if($role == 'Speaker'){
            return redirect('/speaker');
        }
        elseif($role == 'Super Admin'){
            return redirect('/super');
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Events::find($id)->delete();

        $role = $this->Lib->getUserRole(Auth::id());
        if($role == 'Speaker'){
            return redirect('/speaker');
        }
        elseif($role == 'Super Admin'){
            return redirect('/super');
        }
        return redirect('/');
    }


    public function attendToEvent(Request $request){
        if($this->Event->attend($request['eventId'], $request['attendVia'])){
            echo 'success';
        }else{
            echo 'error';
        }
    }


    //only superadmin access
    public function approveEvent(Request $request){
        $eventId = $request['id'];
        unset($request['id']);
        unset($request['_token']);

        $request['approved'] = 1;
        $request['approved_by'] = Auth::id();
        $request['approved_at'] = Carbon::now();
        Events::where('id', $eventId)->update($request->all());

        $request['event_details_pdf_link'] = $this->Event->generateEventDetailsPDF($eventId);
        $this->Event->messageToSpeakerOnApproveEvent($eventId, $request);
        $this->Event->messageToRepresentativeOnCreateOrApproveEvent($eventId, $request);
        //$this->Event->messageToUserOnApproveEvent($eventId);
    }

    public function deleteEvent(Request $request){
        Events::where('id', $request['eventId'])->delete();
    }

    public function getSpeakerNames(){
        $speakers = UserRole::where('role', 'Speaker')->select('user_id')->get();
        foreach ($speakers as $speaker){
            $speaker->only_name = User::find($speaker->user_id)->name;
            $profile = UserProfile::where('user_id', $speaker->user_id)->pluck('label_value')[0];
            $profile = json_decode($profile, true);
            $univId = $profile['univ'];
            if( $univId ){
                $univInfo = $this->HardCodedData->univInfo();
                $speaker->value = $speaker->only_name. '('.($univInfo[$univId]['univ_name']).')';
            }else{
                $speaker->value = $speaker->only_name;
            }

            $speaker->id = $speaker->user_id;
            unset($speaker->user_id);
        }
        return $speakers;
    }


}
