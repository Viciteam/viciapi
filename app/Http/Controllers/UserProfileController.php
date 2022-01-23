<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->user()->id;

        #check if profile exists, if not, create one. if it does, just edit the currentvalues

        $profexists = UserProfile::where('user_id',$data['user_id'])->first();
        if($profexists){
            #edit profile here

            $userProfile = UserProfile::where('user_id',$data['user_id'])->first();

            $userProfile->profpic_link = $data['profpic_link'];
            $userProfile->bgcolor = $data['bgcolor'];
            $userProfile->username = $data['username'];
            $userProfile->txtcolor = $data['txtcolor'];
            $userProfile->name = $data['name'];
            $userProfile->pref_pronoun = $data['pref_pronoun'];
            $userProfile->bday = $data['bday'];
            $userProfile->bio = $data['bio'];
            $userProfile->mission = $data['mission'];
            $userProfile->country = $data['country'];
            $userProfile->profile_banner_link = $data['profile_banner_link'];

            $userProfile->update();

            $response = [
                'user' => $userProfile
            ];
            $code = 200;
        }else{
            #add profile
            $user = UserProfile::create([

                'user_id' => $data['user_id'],
                'profpic_link' => $data['profpic_link'],
                'bgcolor' => $data['bgcolor'],
                'username' => $data['username'],
                'txtcolor' => $data['txtcolor'],
                'name' => $data['name'],
                'pref_pronoun' => $data['pref_pronoun'],
                'bday' => $data['bday'],
                'bio' => $data['bio'],
                'mission' => $data['mission'],
                'country' => $data['country'],
                'profile_banner_link' => $data['profile_banner_link']

            ]);

            $response = [
                'user' => $user
            ];
            $code = 201;
        }
        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userProfile = UserProfile::where('user_id',$id)->first();
        $response = [
            'user' => $userProfile
        ];
        $code = 200;
        return response($response, $code);
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
        //
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
