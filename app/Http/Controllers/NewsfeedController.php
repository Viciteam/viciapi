<?php

namespace App\Http\Controllers;

use App\Models\Newsfeed;
use Illuminate\Http\Request;

class NewsfeedController extends Controller
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
        # 'user_id', 'time', 'post_media','post_message', 'likes', 'dislikes', 'islikeselected',isPrivate
        $newsfeed = Newsfeed::create([
            'user_id' => $data['user_id'],
            'time' => $data['time'],
            'post_media' => $data['post_media'],
            'post_message' => $data['post_message'],
            'likes' => $data['likes'],
            'dislikes' => $data['dislikes'],
            'islikeselected' => $data['islikeselected'],
            'isPrivate' => $data['isPrivate']

        ]);
        $response = [
            'newsfeed_post' => $newsfeed
        ];
        $code = 201;

        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function show(Newsfeed $newsfeed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsfeed $newsfeed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
 # 'user_id', 'time', 'post_media','post_message', 'likes', 'dislikes', 'islikeselected', 'isPrivate'
        $newsfeed = Newsfeed::find($id);                
        $newsfeed->user_id = $data["user_id"];
        $newsfeed->time = $data["time"];
        $newsfeed->post_media = $data["post_media"];
        $newsfeed->post_message = $data["post_message"];
        $newsfeed->likes = $data["likes"];
        $newsfeed->dislikes = $data["dislikes"];
        $newsfeed->islikeselected = $data["islikeselected"];
        $newsfeed->isPrivate = $data["isPrivate"];
        $newsfeed->save();
        $response = [
            'newsfeed_post' => $newsfeed
        ];
        $code = 200;

        return response($response, $code); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsfeed $newsfeed)
    {
        //
    }

    public function get_user_newsfeed($user_id){
        $newsfeed = Newsfeed::where('user_id',$user_id)->paginate(10);
        $response = [
            'newsfeed' => $newsfeed
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_public_newsfeed(){
        $newsfeed = Newsfeed::join('user_profiles', 'user_profiles.user_id', '=', 'newsfeeds.user_id')
        ->select('newsfeeds.*','user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user','user_profiles.username as user_name')
        ->where('isPrivate',"No")
        ->latest('newsfeeds.created_at')
        ->paginate(10);
        $response = [
            'newsfeed' => $newsfeed
        ];
        $code = 200;

        return response($response, $code);
    }

    public function add_reaction(Request $request, $id){
        $data = $request->all();

               $newsfeed = Newsfeed::find($id);                
               if($data["reaction"] == 'Like'){
                    $newsfeed->likes = $newsfeed->likes + 1;
               }
               if($data["reaction"] == 'Dislike'){
                    $newsfeed->dislikes = $newsfeed->dislikes + 1;
               } 
               $newsfeed->save();
               $response = [
                   'newsfeed_post' => $newsfeed
               ];
               $code = 200;
       
               return response($response, $code); 
    }
}
