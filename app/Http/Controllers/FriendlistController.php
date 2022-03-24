<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendList;
use App\Models\UserProfile;

class FriendlistController extends Controller
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
        #query if friend already exists

        $hasfriend = FriendList::where('id',$data['user_id'])
                        ->where('friend_id',$data['friend_id'])
                        ->first();
        if($hasfriend){
            $response = [
                'msg' => 'You already have a request for this user'
            ];
    
            $code = 400;
    
            return response($response, $code);
        }                

        $friendlist = FriendList::create([
            'user_id' => $data['user_id'],
            'friend_id'  => $data['friend_id'],
            'request_status' => 'Pending'
        ]);

        #get friend profile

        $friend_profile = UserProfile::where('id',$data['friend_id'])->first();
        
        $response = [
            'friend' => $friendlist,
            'friend_detail' => $friend_profile
        ];

        $code = 201;

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
        $user_id = $id;
        
        $friendlist = FriendList::where('user_id',$user_id)->get();

        foreach($friendlist as $friend){
            $friendlist['profile'] = UserProfile::where('id',$friend['friend_id'])->first();
        }

        $response = [
            'friends' => $friendlist
        ];

        $code = 200;

        return response($response, $code);
    }

    public function approve_request($requestid){
        
        $friendrequest =  FriendList::where('id',$requestid)->first();
        if($friendrequest->request_status == 'Pending'){
            $friendrequest->request_status = 'Approved';
            $friendrequest->update();

            #create reverse records
            $newfriend = FriendList::create([
                'user_id' => $friendrequest['friend_id'],
                'friend_id'  => $friendrequest['user_id'],
                'request_status' => 'Approved'
            ]);
        }
        $response = [
            'Message' => "Request Approved"
        ];

        $code = 201;

        return response($response, $code);
    }


    public function follow_user(Request $request){
        
        $data = $request->all();
        $friendlist = FriendList::create([
            'user_id' => $data['user_id'],
            'friend_id'  => $data['friend_id'],
            'request_status' => 'Following'
        ]);

        #get user profile

        $friend_profile = UserProfile::where('id',$data['friend_id'])->first();
        
        $response = [
            'friend' => $friendlist,
            'friend_detail' => $friend_profile
        ];

        $code = 201;

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

    public function get_friends($id){
        $user_id = $id;
        
        $friendlist = FriendList::join('user_profiles', 'user_profiles.user_id', '=', 'friend_lists.user_id')
        ->where('friend_lists.user_id',$id)
        ->latest('friend_lists.created_at')
        ->paginate(10);

        foreach($friendlist as $friend){
            $friendlist['profile'] = UserProfile::where('id',$friend['friend_id'])->first();
        }

        $response = [
            'friends' => $friendlist
        ];

        $code = 200;

        return response($response, $code);
    }
}
