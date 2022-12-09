<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/2/18
 * Time: 2:35 PM
 */

namespace App\Library;

use App\User;
use App\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Library
{
    function __construct()
    {
    }


    public function getUserRole($user_id){
        $user = UserRole::where('user_id', $user_id)->get();
        if(count($user) > 0){
            return $user[0]->role;
        }
        return null;
    }

    function generateToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }

        return $token;
    }

    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    public function getAllProfessions(){
        return [
            'Student', 'Lecturer', 'Associate Professor', 'Assistant Professor', 'Professor', 'Employer', 'Researcher'
        ];
    }

    public function adminPanelLink(){
        $userRole = $this->getUserRole(Auth::id());
        if ($userRole == 'Super Admin'){
            return '/super';
        }
        elseif($userRole == 'Speaker'){
            return '/speaker';
        }
        return '/';
    }

    public function getUserName($userId){
        if($user = User::find($userId)){
            return $user->name;
        }
        return 'Unknown';
    }

    public function baseDomain(){
        //return "http://127.0.0.1:8000";
        return "http://eaas.bdren.net.bd";
    }

    public function availableUserRoles(){
        return ['Representative', 'Speaker'];
    }

    public function getSpeakers(){
        $speakers = DB::table('user_roles as ur')->join('users as u', 'ur.user_id', '=', 'u.id')
            ->select('u.name', 'u.email')->where('ur.role', 'Speaker')->get();
        return $speakers;
    }

    public function getRepresentatives(){
        $representatives = DB::table('user_roles as ur')->join('users as u', 'ur.user_id', '=', 'u.id')
            ->select('u.id', 'u.name', 'u.email')->where('ur.role', 'Representative')->get();
        return $representatives;
    }
}