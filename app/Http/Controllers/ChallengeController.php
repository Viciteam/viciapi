<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\ChallengeDetail;
use App\Models\Action;
use App\Models\Tracking;

class ChallengeController extends Controller
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

        #save challenge first and get challenge id

        
        $challenge = Challenge::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'is_template' => $data['is_template'],
            'owner_id' => $data['owner_id']

        ]);
        
        $challenge_id = $challenge['id'];
        $cdetails = [];
        foreach($data['details'] as $detail){
            $challengedetail = ChallengeDetail::create([
                'challenge_id' => $challenge_id,
                'field' => $detail['field'],
                'data' => $detail['data']
    
            ]);
            array_push($cdetails,$challengedetail);
        }

        $response = [
            'challenge' => $challenge,
            'challenge details' => $cdetails
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
                #get challenges per challenge_id
                $challenge_id = $id;
        
                $challenges = Challenge::where('id',$challenge_id)->get();
                $userchallenges = [];
                foreach($challenges as $challenge){
                    $challenge_id = $challenge->id;
        
                    $actions = Action::where('challenge_id',$challenge_id)->get();
                    $challenge['actions'] = $actions;
                    foreach($actions as $action){
                        $action_id = $action->id;
                        $tracking = Tracking::where('action_id',$action->id)->get();
                        
                        $action['trackings'] = $tracking;
                    }
        
        
                    array_push($userchallenges,$challenge);
                }
        
                $response = [
                    'challenges' => $userchallenges
                ];
                $code = 200;
        
                return response($response, $code);
    }

    public function get_challenge_by_user($id){
        $user_id = $id;
        
        $challenges = Challenge::where('owner_id',$user_id)->get();
        $userchallenges = [];
        foreach($challenges as $challenge){
            $challenge_id = $challenge->id;

            $actions = Action::where('challenge_id',$challenge_id)->get();
            $challenge['actions'] = $actions;
            foreach($actions as $action){
                $action_id = $action->id;
                $tracking = Tracking::where('action_id',$action->id)->get();

                $action['trackings'] = $tracking;
            }


            array_push($userchallenges,$challenge);
        }

        $response = [
            'challenges' => $userchallenges
        ];
        $code = 200;

        return response($response, $code);

    }

    public function get_all_challenges(){

        
        $challenges = Challenge::all();
        $userchallenges = [];
        foreach($challenges as $challenge){
            $challenge_id = $challenge->id;

            $actions = Action::where('challenge_id',$challenge_id)->get();
            $challenge['actions'] = $actions;
            foreach($actions as $action){
                $action_id = $action->id;
                $tracking = Tracking::where('action_id',$action->id)->get();

                $action['trackings'] = $tracking;
            }


            array_push($userchallenges,$challenge);
        }

        $response = [
            'challenges' => $userchallenges
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
       
        
        $challenge = Challenge::where('id',$id);
        

        $response = [
            'challenges' => $userchallenges
        ];
        $code = 200;

        return response($response, $code);
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
