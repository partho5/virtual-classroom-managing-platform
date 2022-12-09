<?php

namespace App\Http\Controllers;

use App\Events;
use App\Library\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpeakerController extends Controller
{
    private $Lib;

    function __construct()
    {
        $this->middleware('auth');
        $this->Lib = new Library();
    }


    public function index(){
        $otherEvents = Events::where('creator_id', '!=' ,Auth::id())->get();
        foreach ($otherEvents as $event){
            $event['speakerName'] = $this->Lib->getUserName($event->speaker_id);
        }
        return view('speaker.board', [
            'otherEvents'   => $otherEvents,
        ]);
    }

    public function createEvent(Request $request){

    }
}
