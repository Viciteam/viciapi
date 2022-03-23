<?php

namespace App\Http\Controllers;

use App\Models\ChallengeComment;
use Illuminate\Http\Request;

class ChallengeCommentController extends Controller
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
        $comment = ChallengeComment::create([
            'user_id' => $data['user_id'],
            'challenge_id' => $data['challenge_id'],
            'time' => $data['time'],
            'comment_media' => $data['post_media'],
            'comment_message' => $data['post_message'],
            'likes' => $data['likes'],
            'dislikes' => $data['dislikes'],
            'islikeselected' => $data['islikeselected']

        ]);
        $response = [
            'challenge_comment' => $comment
        ];
        $code = 201;

        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChallengeComment  $challengeComment
     * @return \Illuminate\Http\Response
     */
    public function show(ChallengeComment $challengeComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChallengeComment  $challengeComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ChallengeComment $challengeComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChallengeComment  $challengeComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $comment = ChallengeComment::find($id);                
        $comment->user_id = $data["user_id"];
        $comment->time = $data["time"];
        $comment->comment_media = $data["post_media"];
        $comment->comment_message = $data["post_message"];
        $comment->likes = $data["likes"];
        $comment->dislikes = $data["dislikes"];
        $comment->islikeselected = $data["islikeselected"];
        $comment->challenge_id = $data["challenge_id"];
        $comment->save();
        $response = [
            'challenge_comment' => $comment
        ];
        $code = 200;

        return response($response, $code); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChallengeComment  $challengeComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChallengeComment $challengeComment)
    {
        //
    }

    public function get_challenge_comments($challenge_id){
        $comments = ChallengeComment::where('challenge_id',$challenge_id)->paginate(10);
        $response = [
            'comments' => $comments
        ];
        $code = 200;

        return response($response, $code);
    }
    public function add_reaction(Request $request, $id){
        $data = $request->all();

               $comment = ChallengeComment::find($id);                
               if($data["reaction"] == 'Like'){
                    $comment->likes = $comment->likes + 1;
               }
               if($data["reaction"] == 'Dislike'){
                    $comment->dislikes = $comment->dislikes + 1;
               } 
               $comment->save();
               $response = [
                   'challenge_comment' => $comment
               ];
               $code = 200;
       
               return response($response, $code); 
    }
}
