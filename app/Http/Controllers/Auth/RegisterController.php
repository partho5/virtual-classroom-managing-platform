<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\UserProfile;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if($user->id == 1){
            UserRole::insert([
                'user_id'               => $user->id,
                'role'                  => 'Super Admin',
                'role_assigned_by'      => 1,
                'created_at'            => Carbon::now(),
            ]);
        }

        UserProfile::insert([
            'user_id'       => $user->id,
            'label_value'   => "{\"name\":\"$user->name\",\"email\":\"$user->email\",\"phone\":null,\"pp_src\":null,\"univ\":null,\"dept\":null,\"profession\":[\"Student\"],\"phd\":\"No\",\"job-institute\":null,\"user_id\":\"$user->id\"}",
            'created_at'    => Carbon::now(),
        ]);

        return $user;
    }
}
