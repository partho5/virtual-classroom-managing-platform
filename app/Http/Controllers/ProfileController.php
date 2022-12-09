<?php

namespace App\Http\Controllers;

use App\Library\Library;
use App\Modules\Misc\HardCodedData;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $Lib, $HardCodedData;

    function __construct()
    {
        $this->middleware('auth');
        $this->Lib = new Library();
        $this->HardCodedData = new HardCodedData();
    }

    public function index()
    {
        $profileData = UserProfile::where('user_id', Auth::id())->get();
        $profileData = json_decode($profileData[0]->label_value, true);
        if( ! isset($profileData['profession']) ){
            $profileData['profession'] = ['Student'];
        }

        $univInfo = $this->HardCodedData->univInfo();
        sort($univInfo);

        if(count($profileData) > 0){
            return view('profile.user-profile', [
                'profileData'       => $profileData,
                'allProfessions'    => $this->Lib->getAllProfessions(),
                'univInfo'          => $univInfo,
            ]);
        }
        return view('profile.user-profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "show the public view of profile id $id";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $fileObj = $request->file('pp');
        if( isset($fileObj) ){
            Storage::disk('uploaded')->put('pp/'.$fileObj->getClientOriginalName(), $fileObj, 'public');
            $request['pp_src'] = 'pp/'.$fileObj->getClientOriginalName().'/'.$fileObj->hashName();
        }
        unset($request['_token']);
        unset($request['_method']);

        $request['user_id'] = $id;
        $request['label_value'] = json_encode($request->all());
        $profileData = $request->only(['user_id', 'label_value']);

        UserProfile::where('user_id', $id)->update($profileData);

        return redirect('/');
        return redirect('/user/profile')->with('profileData', $profileData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
