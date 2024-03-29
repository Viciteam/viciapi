<?php

namespace App\Http\Controllers;

use App\Models\NewsfeedComment;
use Illuminate\Http\Request;

class NewsfeedCommentController extends Controller
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
        $comment = NewsfeedComment::create([
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id'],
            'time' => $data['time'],
            'post_media' => $data['post_media'],
            'post_message' => $data['post_message'],
            'likes' => $data['likes'],
            'dislikes' => $data['dislikes'],
            'islikeselected' => $data['islikeselected']

        ]);
        $response = [
            'newsfeed_comment' => $comment
        ];
        $code = 201;

        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return \Illuminate\Http\Response
     */
    public function show(NewsfeedComment $newsfeedComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsfeedComment $newsfeedComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
               $comment = NewsfeedComment::find($id);                
               $comment->user_id = $data["user_id"];
               $comment->time = $data["time"];
               $comment->post_media = $data["post_media"];
               $comment->post_message = $data["post_message"];
               $comment->likes = $data["likes"];
               $comment->dislikes = $data["dislikes"];
               $comment->islikeselected = $data["islikeselected"];
               $comment->post_id = $data["post_id"];
               $comment->save();
               $response = [
                   'newsfeed_comment' => $comment
               ];
               $code = 200;
       
               return response($response, $code); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsfeedComment $newsfeedComment)
    {
        //
    }

    public function get_post_comments($post_id){
        $comments = NewsfeedComment::join('user_profiles', 'user_profiles.user_id', '=', 'newsfeed_comments.user_id')
        ->select('newsfeed_comments.*','user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user','user_profiles.username as user_name')
        ->where('post_id',$post_id)
        ->latest('newsfeed_comments.created_at')
        ->paginate(10);
        
        $data = [];
        array_push($data,$comments);

        $response = [
            'comments' => $comments
        ];
        $code = 200;

        return response($response, $code);
    }
    public function add_reaction(Request $request, $id){
        $data = $request->all();

               $comment = NewsfeedComment::find($id);                
               if($data["reaction"] == 'Like'){
                    $comment->likes = $comment->likes + 1;
               }
               if($data["reaction"] == 'Dislike'){
                    $comment->dislikes = $comment->dislikes + 1;
               } 
               $comment->save();
               $response = [
                   'newsfeed_comment' => $comment
               ];
               $code = 200;
       
               return response($response, $code); 
    }
}
