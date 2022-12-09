<?php

namespace App\Http\Middleware;

use App\Library\Library;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserRoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $Lib, $userRole;

    private $openForAll = ['event_create_helper/get_representative_names'];

    private $allowedRoutesForSuperAdmin = [
        'super' , 'user', 'event', 'invitation', 'home', 'login', 'register', 'logout'
    ];
    private $allowedRoutesForSpeaker = [
        'speaker' , 'user', 'event', 'invitation', 'home', 'login', 'register', 'logout'
    ];
    private $allowedRoutesForRepresentative = [
        'representative' , 'user', 'event', 'invitation', 'home', 'login', 'register', 'logout'
    ];
    private $allowedRoutesForNormalUser = [
        'user', 'event', 'home', 'invitation', 'login', 'register', 'logout'
    ];
    function __construct()
    {
        $this->Lib = new Library();
        $this->userRole = $this->Lib->getUserRole(Auth::id());
    }

    public function handle($request, Closure $next)
    {
        $relativeUrl = $request->path();

        if($this->userRole === null){
            //this user is a general user with NO role
            if( ! $this->isRoutePrefixAllowed($relativeUrl, $this->allowedRoutesForNormalUser) ){
                return abort(401);
            }
        }
        if($this->userRole === "Super Admin"){
            if( ! $this->isRoutePrefixAllowed($relativeUrl, $this->allowedRoutesForSuperAdmin) ){
                return abort(401);
            }
        }
        //dont use elseif, because someone may have multiple user roles
        if($this->userRole === "Speaker"){
            if( ! $this->isRoutePrefixAllowed($relativeUrl, $this->allowedRoutesForSpeaker) ){
                return abort(401);
            }
        }
        if($this->userRole === "Representative"){
            if( ! $this->isRoutePrefixAllowed($relativeUrl, $this->allowedRoutesForRepresentative) ){
                return abort(401);
            }
        }


        return $next($request);
    }

    private function isRoutePrefixAllowed($prefix, $allowedPrefixArray){
        $parts = explode("/", $prefix);
        return in_array($parts[0], $allowedPrefixArray) || $prefix == "/"
            || in_array($prefix, $this->openForAll);
    }

}
