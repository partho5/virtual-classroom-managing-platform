<?php

namespace App\Http\Controllers;

use App\Events;
use App\Library\Library;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $Lib;

    public function __construct()
    {
        $this->middleware('auth')->except(['showHomePage']);

        $this->Lib = new Library();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function showHomePage(Request $request){
        $upcomingEvents = Events::where('talk_delivery_time', '>=', Carbon::now())
            ->where('approved', 1)->take(4)->get();

        $role = $this->Lib->getUserRole(Auth::id());
        $dashboardLink = "/user/board";
        if($role == 'Super Admin'){
            $dashboardLink = '/super';
        } elseif ($role == 'Speaker'){
            $dashboardLink = '/speaker';
        } elseif ($role == 'Representative'){
            $dashboardLink = '/representative';
        }

        return view('basic.homepage', [
            'dashboardLink'         => $dashboardLink,
            'upcomingEvents'        => $upcomingEvents,
        ]);
    }

    public function index()
    {
        return redirect('/');



        //return view('home');
    }
}
