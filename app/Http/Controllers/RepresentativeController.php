<?php

namespace App\Http\Controllers;

use App\Events;
use App\Library\Library;
use App\Modules\Events\EventProcessor;
use App\Modules\Representative\RepresentativeProcessor;
use App\Modules\SoftCode\FormField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepresentativeController extends Controller
{
    private $Lib, $Representative, $Event, $FormField;

    function __construct()
    {
        $this->middleware('auth');
        $this->Lib = new Library();
        $this->Representative = new RepresentativeProcessor();
        $this->Event = new EventProcessor();
        $this->FormField = new FormField();
    }


    public function index(){
        $upcomingEvents = Events::where('talk_delivery_time', '>=', Carbon::now())->get();
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
        return view('representative.panel', [
            'upcomingEvents'        => $upcomingEvents,
            'pastEvents'            => $pastEvents,
            'attendViaFormField'    => $this->FormField->attendToEventVia(),
        ]);
    }

}
